<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Subscription;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;


class DoctorAuthController extends Controller
{


    public function showLogin()
    {

        return view('doctor.auth.login');
    }

    public function login(Request $request)
    {
        // Validate the input fields
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user against the 'doctor' guard
        if (Auth::guard('doctor')->attempt($credentials)) {
            // If successful, redirect to the doctor's dashboard
            return redirect()->route('doctor.dashboard');
        }

        // If authentication fails, redirect back with errors
        return redirect()->route('doctor.login')
            ->withErrors(['email' => 'Invalid email or password.']) // Flash error message
            ->withInput($request->only('email')); // Preserve the email field value
    }


    public function logout()
    {
        Auth::guard('doctor')->logout();
        return redirect()->route('doctor.login');
    }



    public function create()
    {
        $specializations = Specialization::all();
        return view('auth.register-doctor', compact('specializations'));
    }


    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20|unique:doctors',
            'specialization_id' => 'required|exists:specializations,id',
            'bio' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'price_per_appointment' => 'required|numeric|min:0',
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
            'doctor_document' => 'required|file|mimes:pdf|max:5120', // 5MB max
            'governorate' => 'required|in:Amman,Irbid,Ajloun,Aqaba,Balqa,Zarqa,Mafraq,Maan,Tafilah,Karak,Jerash',
            'address' => 'required|string|max:255',
            'monday' => 'nullable|boolean',
            'tuesday' => 'nullable|boolean',
            'wednesday' => 'nullable|boolean',
            'thursday' => 'nullable|boolean',
            'friday' => 'nullable|boolean',
            'saturday' => 'nullable|boolean',
            'sunday' => 'nullable|boolean',
        ]);

        // Handle file uploads
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctor_images', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->hasFile('doctor_document')) {
            $documentPath = $request->file('doctor_document')->store('doctor_documents', 'public');
            $validated['doctor_document'] = $documentPath;
        }

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Set default status
        $validated['status'] = 'pending'; // Default status for new doctors

        // Process days (convert checkbox values to booleans)
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            $validated[$day] = $request->has($day);
        }

        // Create the doctor
        $doctor = Doctor::create($validated);


        // Login the doctor
        Auth::login($doctor);

        return redirect()->route('doctor.dashboard')
            ->with('success', 'Doctor registered successfully! Your account is pending approval.');
    }


    public function show()
    {
        $doctor = Auth::guard('doctor')->user();


        // Get appointments with patients eager loaded
        $upcomingAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', now())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(5);

        $recentAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '<', now())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(5);

        // Get appointment counts in a single query for better performance
        $appointmentCounts = Appointment::where('doctor_id', $doctor->id)
            ->selectRaw('count(*) as total')
            ->selectRaw('sum(case when status = "canceled" then 1 else 0 end) as canceled')
            ->selectRaw('sum(case when status = "pending" then 1 else 0 end) as pending')
            ->selectRaw('sum(case when status = "confirmed" then 1 else 0 end) as completed')
            ->first();

        // Format working hours for the view
        $workingHours = null;
        if ($doctor->working_hours_start && $doctor->working_hours_end) {
            $workingHours = [
                'start' => \Carbon\Carbon::parse($doctor->working_hours_start)->format('h:i A'),
                'end' => \Carbon\Carbon::parse($doctor->working_hours_end)->format('h:i A')
            ];
        }
        // dd($doctor->monday);
        // Get available days
        $availableDays = collect([
            'monday' => $doctor->monday ? 'Monday' : null,
            'tuesday' => $doctor->tuesday ? 'Tuesday' : null,
            'wednesday' => $doctor->wednesday ? 'Wednesday' : null,
            'thursday' => $doctor->thursday ? 'Thursday' : null,
            'friday' => $doctor->friday ? 'Friday' : null,
            'saturday' => $doctor->saturday ? 'Saturday' : null,
            'sunday' => $doctor->sunday ? 'Sunday' : null
        ])->filter()->values()->toArray();


        return view('doctor.index', [
            'doctor' => $doctor,
            'upcomingAppointments' => $upcomingAppointments,
            'recentAppointments' => $recentAppointments,
            'total_appointments' => $appointmentCounts->total,
            'canceled_appointments' => $appointmentCounts->canceled,
            'pending_appointments' => $appointmentCounts->pending,
            'completed_appointments' => $appointmentCounts->completed,
            'workingHours' => $workingHours,
            'availableDays' => $availableDays
        ]);
    }








}
