<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialization;

class DoctorsPageController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index(Request $request)
{
    // Start with a base query for approved doctors
    $query = Doctor::query()->where('status', 'approved')->with('specialization');

    // Apply search if provided
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhereHas('specialization', function($sq) use ($search) {
                  $sq->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Filter by governorate if selected
    if ($request->filled('governorate')) {
        $query->where('governorate', $request->governorate);
    }

    // Filter by specializations if selected
    if ($request->filled('specializations')) {
        $query->whereIn('specialization_id', $request->specializations);
    }

    // Apply sorting
    switch ($request->input('sort', 'recommended')) {
        case 'rating':
            // Assuming you have a 'rating' column or relationship
            $query->orderBy('rating', 'desc')
                  ->orderBy('name', 'asc'); // Secondary sort
            break;

        case 'experience':
            $query->orderBy('experience_years', 'desc')
                  ->orderBy('name', 'asc'); // Secondary sort
            break;

        default: // 'recommended' or default
            $query->orderBy('name', 'asc');
            break;
    }

    // Get paginated results (9 per page to fit the 3-column layout better)
    $doctors = $query->paginate(6)->withQueryString();

    // Get all specializations for the filter
    $specializations = Specialization::orderBy('name')->get();

    // Get total doctor count for stats
    $totalDoctors = Doctor::where('status', 'approved')->count();

    return view('public.doctors', [
        'doctors' => $doctors,
        'specializations' => $specializations,
        'totalDoctors' => $totalDoctors
    ]);
}

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $doctor = Doctor::with('specialization')->findOrFail($id);

        return view('public.doctor', compact('doctor'));
    }


}
