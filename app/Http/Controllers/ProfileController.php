<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{

    public function index(Request $request): View
{
    $user = Auth::user();

    $appointments = Appointment::with([
            'doctor.specialization',
            'doctor' => function($query) {
                $query->withDefault([
                    'image' => 'images/default-doctor.jpg',
                    'name' => 'Unknown Doctor'
                ]);
            }
        ])
        ->where('patient_id', $user->patient->id)
        ->when($request->status, function($query, $status) {
            return $query->where('status', $status);
        })
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'desc')
        ->paginate(100);

    // $doctors = $user->patient->favoriteDoctors()
    //     ->with('specialization')
    //     ->get();


    return view('public.profile', [
        'appointments' => $appointments,
        // 'doctors' => $doctors,
        'currentStatus' => $request->status
    ]);
}

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Store new image
            $user->image = $request->file('image')->store('profile-images', 'public');
        }

        // Update other fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
