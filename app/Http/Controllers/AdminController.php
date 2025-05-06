<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;




class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Admin::withTrashed()
        ->when($request->search, function($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->when($request->status == 'archived', function($query) {
            $query->onlyTrashed();
        })
        ->when($request->status == 'active', function($query) {
            $query->whereNull('deleted_at');
        })
        ->when($request->status == 'super_admin', function($query) {
            $query->where('role', 'super_admin')->whereNull('deleted_at');
        })
        ->when($request->status == 'admin', function($query) {
            $query->where('role','admin')->whereNull('deleted_at');
        })
        ->orderBy('deleted_at')
        ->orderBy('id', 'desc');

    $admins = $query->paginate(10);

    return view('admin.admins', compact('admins'));
}



    public function create()
    {

    }





    public function show(Admin $admin)
    {

    }


    public function edit(Admin $admin)
    {

    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins,email,'.$admin->id,
            'password'=>'required|confirmed|min:6',
        ]);

        $admin->update($request->all());
        return redirect()->route('admins.index')->with('success','Admin updated successfully');
    }


    public function destroy(Admin $admin)
    {
        // dd($admin->id);
        $admin->delete();
        return redirect()->back()->with('success','Admin deleted successfully');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string',
        ]);

        // Create the admin
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
            'phone' => $request->phone,
            'role' => $request->role ?? 'admin',
        ]);

        // Redirect with success message
        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }

    public function chart()
    {
        // Total counts
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalSpecializations = Specialization::count();
        $totalAppointments = Appointment::count();

        // Pie Chart: Doctors by specialization
        $specializationCounts = Specialization::withCount('doctors')
            ->get()
            ->map(function ($specialization) {
                return [
                    'name' => $specialization->name,
                    'count' => $specialization->doctors_count,
                ];
            });

        // Horizontal Bar Chart: Top 5 specializations with the most doctors
        $topSpecializations = Specialization::withCount('doctors')
            ->orderByDesc('doctors_count')
            ->take(5)
            ->get()
            ->map(function ($specialization) {
                return [
                    'name' => $specialization->name,
                    'count' => $specialization->doctors_count,
                ];
            });

        // Pass all data to the view
        return view('admin.chart', compact(
            'totalUsers',
            'totalDoctors',
            'totalSpecializations',
            'totalAppointments',
            'specializationCounts',
            'topSpecializations'
        ));
    }

}
