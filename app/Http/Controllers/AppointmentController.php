<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Doctor;
use App\Models\DoctorUnavailability;
use App\Models\Patient;
use App\Mail\AppointmentStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Create a query builder
        $query = Appointment::with('doctor', 'patient');
        
        // Apply search if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('doctor', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('patient', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('appointment_date', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Apply doctor filter if provided
        if ($request->has('doctor_id') && $request->doctor_id != 'all') {
            $query->where('doctor_id', $request->doctor_id);
        }
        
        // Get paginated results
        $appointments = $query->paginate(5);
        
        // Get all doctors and patients for filters
        $doctors = Doctor::all();
        $patients = Patient::all();

        return view('admin.appointments', compact('appointments', 'doctors', 'patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = \App\Models\Doctor::all();
        $patients = \App\Models\Patient::all();

        return view('admin.appointments.create', compact('doctors', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        // Convert time to proper format
        $time = date('H:i:s', strtotime($request->appointment_time));

        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $time,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }


    public function doctorStore(Request $request)
{
    $request->validate([
        'patient_name' => 'required|string|max:255',
        'patient_phone' => 'required|string|max:20',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required|date_format:H:i',
        'doctor_id' => 'required|exists:doctors,id',
        'status' => 'sometimes|in:pending,confirmed,canceled,completed'
    ]);

    try {
        DB::beginTransaction();

        // First, find or create the patient
        $patient = Patient::firstOrCreate(
            ['phone' => $request->patient_phone],
            ['name' => $request->patient_name]
        );

        // Create the appointment
        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status ?? 'confirmed',
            'payment_status' => 'unpaid',
            'source' => 'doctor_portal'
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'appointment' => $appointment
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to create appointment: ' . $e->getMessage()
        ], 500);
    }
}


    public function show(Appointment $appointment)
    {
        $appointment->load('doctor', 'patient');

        return view('admin.appointments.show', compact('appointment'));
    }


    public function edit(Appointment $appointment)
    {
        $doctors = \App\Models\Doctor::all();
        $patients = \App\Models\Patient::all();

        return view('admin.appointments.edit', compact('appointment', 'doctors', 'patients'));
    }



    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'nullable|exists:patients,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,canceled',
            'payment_status' => 'required|in:paid,unpaid',
        ];
    }



    public function update(Request $request, Appointment $appointmentId)
    {
        $previousStatus = $appointmentId->status;
        $newStatus = $request->status;

        // Update the appointment status
        $appointmentId->update(['status' => $newStatus]);

        if ($newStatus === 'confirmed' && $previousStatus !== 'confirmed') {
            // Add to unavailabilities only if it wasn't already confirmed
            DoctorUnavailability::create([
                'doctor_id' => $appointmentId->doctor_id,
                'date' => $appointmentId->appointment_date,
                'start_time' => $appointmentId->appointment_time,
            ]);
        }
        elseif ($newStatus === 'canceled' && $previousStatus === 'confirmed') {
            // Only remove from unavailabilities if it was previously confirmed
            DoctorUnavailability::where([
                'doctor_id' => $appointmentId->doctor_id,
                'date' => $appointmentId->appointment_date,
                'start_time' => $appointmentId->appointment_time,
            ])->delete();
        }

        // Send email notification if status is confirmed or canceled
        if (($newStatus === 'confirmed' || $newStatus === 'canceled') && $appointmentId->patient && $appointmentId->patient->user) {
            try {
                Mail::to($appointmentId->patient->user->email)
                    ->send(new AppointmentStatusMail($appointmentId));
            } catch (\Exception $e) {
                // Log the error but don't stop the process
                \Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }

        $message = match($newStatus) {
            'confirmed' => 'Appointment confirmed successfully.',
            'canceled' => 'Appointment canceled successfully.',
            default => 'Appointment status updated successfully.'
        };

        return back()->with('success', $message);
    }
}
