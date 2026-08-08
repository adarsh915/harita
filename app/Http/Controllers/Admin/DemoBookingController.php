<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoBooking;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DemoBookingController extends Controller
{
    public function index()
    {
        $demos = DemoBooking::with(['teacher.user', 'convertedStudent.user'])->orderBy('scheduled_at', 'desc')->get();
        $teachers = Teacher::with('user')->get();
        return view('admin.demos.index', compact('demos', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'instrument' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:15',
        ]);

        DemoBooking::create($validated);

        return back()->with('success', 'Demo class scheduled successfully.');
    }

    public function updateStatus(Request $request, DemoBooking $demo)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled', 'no-show'])],
        ]);

        if ($demo->status === 'converted') {
            return back()->with('error', 'Cannot update status of a converted demo.');
        }

        $demo->update(['status' => $validated['status']]);

        return back()->with('success', 'Demo status updated successfully.');
    }

    public function convert(Request $request, DemoBooking $demo)
    {
        if ($demo->status === 'converted') {
            return back()->with('error', 'Demo is already converted.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'enrolled_level' => 'required|string',
            'instrument' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'package' => 'required|string',
            'amount_paid' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
        ]);

        // Parse package to get credits
        $credits = 0;
        if ($validated['package']) {
            $parts = explode('|', $validated['package']);
            if (count($parts) > 1) {
                $credits = (int) $parts[1];
            }
        }

        DB::transaction(function () use ($demo, $validated, $credits) {
            // 1. Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]);
            $user->assignRole('Student');

            // 2. Create Student profile
            $student = Student::create([
                'user_id' => $user->id,
                'teacher_id' => $validated['teacher_id'], // Assign the selected teacher
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'enrolled_level' => $validated['enrolled_level'],
                'credits' => $credits,
            ]);

            // 3. Create Payment record if amount > 0
            if ($validated['amount_paid'] > 0) {
                \App\Models\Payment::create([
                    'student_name' => $validated['name'],
                    'contact' => $validated['email'],
                    'instrument' => $validated['instrument'],
                    'amount' => $validated['amount_paid'],
                    'payment_mode' => $validated['payment_mode'],
                    'transaction_date' => now(),
                    'status' => 'confirmed',
                    'converted_student_id' => $student->id,
                ]);
            }

            // 4. Create Initial Credit Transaction if credits were assigned
            if ($credits > 0) {
                $packageName = explode('|', $validated['package'])[0] ?? 'Initial Package';
                \App\Models\CreditTransaction::create([
                    'student_id' => $student->id,
                    'action' => 'Added',
                    'quantity' => $credits,
                    'reason' => 'Purchased ' . $packageName,
                ]);
            }

            // 3. Mark Demo as Converted
            $demo->update([
                'status' => 'converted',
                'converted_student_id' => $student->id
            ]);
        });

        return back()->with('success', 'Demo converted successfully. Student account created with default password "password123".');
    }
}
