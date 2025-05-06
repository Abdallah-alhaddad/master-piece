<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function showRatingForm(Appointment $appointment)
    {
        // Check if the appointment belongs to the authenticated user
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            return back()->with('error', 'You can only rate your own appointments.');
        }

        // Check if the appointment is confirmed
        if ($appointment->status !== 'confirmed') {
            return back()->with('error', 'You can only rate confirmed appointments.');
        }

        // Check if already rated
        if (Rating::where('appointment_id', $appointment->id)->exists()) {
            return back()->with('error', 'You have already rated this appointment.');
        }

        return view('public.appointment-complete', compact('appointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        // Check if the appointment belongs to the authenticated user
        $appointment = Appointment::findOrFail($request->appointment_id);
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            return back()->with('error', 'You can only rate your own appointments.');
        }

        // Check if the appointment is confirmed
        if ($appointment->status !== 'confirmed') {
            return back()->with('error', 'You can only rate confirmed appointments.');
        }

        // Check if already rated
        if (Rating::where('appointment_id', $request->appointment_id)->exists()) {
            return back()->with('error', 'You have already rated this appointment.');
        }

        // Create the rating
        Rating::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => Auth::user()->patient->id,
            'user_id' => Auth::id(),
            'appointment_id' => $request->appointment_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update appointment status to confirmed (since completed is not a valid status)
        $appointment->update(['status' => 'confirmed']);

        return redirect()->route('profile')->with('success', 'Thank you for your rating!');
    }
} 