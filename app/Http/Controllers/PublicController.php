<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemoBooking;
use Carbon\Carbon;

class PublicController extends Controller
{
    public function storeDemo(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'instrument' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
        ]);

        $startsAt = Carbon::parse($validated['scheduled_at']);

        // Since Razorpay is not implemented yet, we simulate a successful payment
        // and create the demo booking.
        $demoBooking = DemoBooking::create([
            'student_name' => $validated['student_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'instrument' => $validated['instrument'],
            'scheduled_at' => $startsAt,
            'duration_minutes' => 40,
            'status' => 'scheduled',
        ]);

        return back()->with('demo_success', true);
    }
}
