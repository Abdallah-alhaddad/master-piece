<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

use App\Models\Specialization;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\DoctorStatusMail;
use Illuminate\Support\Facades\Mail;

class DoctorController extends Controller
{

    // public function show(Doctor $doctor)
    // {
    //     return view('doctor.index');
    // }

    public function index(Request $request)
    {
        // Fetch doctors with pagination and search
        $query = Doctor::with('specialization')
            ->orderBy('created_at', 'desc');
        
        // Apply search if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('governorate', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Apply specialization filter if provided
        if ($request->has('specialization') && $request->specialization != 'all') {
            $query->where('specialization_id', $request->specialization);
        }
        
        // Get paginated results
        $doctors = $query->paginate(5);

        // Fetch all specializations
        $specializations = Specialization::all();

        // Pass both variables to the view
        return view('admin.doctors.index', compact('doctors', 'specializations'));
    }


   /**
     */
    public function edit(Doctor $doctor)
    {
        if (auth()->guard('doctor')->id() === $doctor->id) {
        $specializations = Specialization::all();
        return view('doctor.edit', compact('doctor', 'specializations'));
        } else {
            return redirect()->route('doctor.dashboard');
        }
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {

        $data = $request->except(['image', 'doctor_document', 'password']);

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            $data['image'] = $request->file('image')->store('doctors/images', 'public');
        }

        // Handle document upload
        if ($request->hasFile('doctor_document')) {
            // Delete old document if exists
            if ($doctor->doctor_document) {
                Storage::disk('public')->delete($doctor->doctor_document);
            }
            $data['doctor_document'] = $request->file('doctor_document')->store('doctors/documents', 'public');
        }

        // Update boolean fields for days
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            $data[$day] = $request->has($day);
        }

        $doctor->update($data);

        return back()->with('success', 'Doctor updated successfully!');
    }

    public function updateDoctor(Request $request, Doctor $doctor)
    {

        $data = $request->except(['image', 'doctor_document', 'password']);

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            $data['image'] = $request->file('image')->store('doctors/images', 'public');
        }

        // Handle document upload
        if ($request->hasFile('doctor_document')) {
            // Delete old document if exists
            if ($doctor->doctor_document) {
                Storage::disk('public')->delete($doctor->doctor_document);
            }
            $data['doctor_document'] = $request->file('doctor_document')->store('doctors/documents', 'public');
        }

        // Update boolean fields for days
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            $data[$day] = $request->has($day);
        }

        $doctor->update($data);

        return back()->with('success', 'Doctor updated successfully!');
    }

    public function updateStatus(Request $request, Doctor $doctor)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $previousStatus = $doctor->status;
        $newStatus = $request->status;

        // Update doctor status
        $doctor->update(['status' => $newStatus]);

        // Send email notification
        try {
            Mail::to($doctor->email)
                ->send(new DoctorStatusMail($doctor, $newStatus));
        } catch (\Exception $e) {
            \Log::error('Failed to send doctor status email: ' . $e->getMessage());
        }

        $message = $newStatus === 'approved' 
            ? 'Doctor account approved successfully.'
            : 'Doctor account rejected successfully.';

        return back()->with('success', $message);
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}

