<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassBooking;
use App\Models\Feedback;
use App\Models\Referral;
use App\Models\Teacher;
use App\Models\TeacherLeave;
use App\Models\TeacherPayroll;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    private function teacher(): ?Teacher
    {
        return Teacher::where('user_id', auth()->id())->first();
    }

    public function dashboard(): View
    {
        $teacher      = $this->teacher();
        $todayClasses = $teacher
            ? ClassBooking::where('teacher_id', $teacher->id)
                ->whereDate('starts_at', today())
                ->where('status', 'scheduled')
                ->with('student')
                ->get()
            : collect();
        return view('teacher.dashboard', compact('teacher', 'todayClasses'));
    }

    public function myClasses(): View
    {
        $teacher = auth()->user()->teacher;
        $classes = ClassBooking::where('teacher_id', $teacher->id)->with('student')->latest('starts_at')->paginate(15);
        return view('teacher.my-classes', compact('classes'));
    }

    public function leaves(): View
    {
        $teacher = auth()->user()->teacher;
        $leaves = TeacherLeave::where('teacher_id', $teacher->id)->latest()->get();
        $teachers = Teacher::where('id', '!=', $teacher->id)->get();
        return view('teacher.leaves', compact('leaves', 'teachers'));
    }

    public function applyLeave(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'from_date'     => ['required', 'date'],
            'to_date'       => ['required', 'date', 'after_or_equal:from_date'],
            'reason'        => ['required', 'string'],
            'cover_teacher' => ['nullable', 'string'],
        ]);

        $teacher = auth()->user()->teacher;
        TeacherLeave::create($data + ['teacher_id' => $teacher->id, 'status' => 'pending']);
        return back()->with('success', 'Leave applied successfully.');
    }

    public function payroll(): View
    {
        $teacher = auth()->user()->teacher;
        $payrolls = TeacherPayroll::where('teacher_id', $teacher->id)->latest('month')->get();
        return view('teacher.payroll', compact('payrolls'));
    }

    public function feedbacks(): View
    {
        $teacher = auth()->user()->teacher;
        $feedbacks = Feedback::where('teacher_id', $teacher->id)->with('student')->latest()->get();
        return view('teacher.feedbacks', compact('feedbacks'));
    }

    public function referrals(): View
    {
        $referrals = Referral::where('referrer_id', auth()->id())->latest()->get();
        return view('teacher.referrals', compact('referrals'));
    }

    public function storeReferral(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'referred_name'  => ['required', 'string'],
            'referred_phone' => ['required', 'string'],
            'interest_role'  => ['required', 'string'],
        ]);

        Referral::create($data + [
            'referrer_id' => auth()->id(),
            'referrer_role' => 'teacher',
            'bonus_reward' => 'Rs 500 Bonus',
            'status' => 'pending'
        ]);
        return back()->with('success', 'Referral submitted.');
    }

    public function profile(): View
    {
        $teacher = auth()->user()->teacher;
        return view('teacher.profile', compact('teacher'));
    }

    public function settings(): View
    {
        $user = auth()->user();
        return view('teacher.settings', compact('user'));
    }

    public function saveSettings(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $user->name = $request->input('name', $user->name);
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return back()->with('success', 'Settings saved.');
    }
}
