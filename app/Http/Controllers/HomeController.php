<?php



namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get random featured doctors (10)
        $featuredDoctors = Doctor::where('status', 'pending')
            ->with('specialization')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        // Get all specializations for search
        $specializations = Specialization::orderBy('name')->get();

        // Statistics
        $stats = [
            'doctors_count' => Doctor::where('status', 'approved')->count(),
            'happy_patients' => Appointment::count(), // Or any other metric you prefer
        ];

        return view('public.welcome', compact('featuredDoctors', 'specializations', 'stats'));
    }
}
