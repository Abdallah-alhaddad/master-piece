<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Http\Requests\StoreSpecializationRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Create a query builder
        $query = Specialization::orderBy('id', 'desc');
        
        // Apply search if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Get paginated results
        $specializations = $query->paginate(5);
        
        return view('admin.specializations', compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('view.specialization.create');
    }

    /**
     * Store a newly created specialization in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:specializations',
            'description' => 'nullable|string',
        ]);

        // Create the specialization
        Specialization::create([
            'name' => $request->name,
            'description' => $request->description,
           'created_by' => auth()->guard('admin')->id(), // Assuming the logged-in user creates the specialization
        ]);

        // Redirect with success message
        return redirect()->route('specializations.index')->with('success', 'Specialization created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization $specialization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialization $specialization)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
        ]);

        $specialization->update($request->all());
        return redirect()->route('specializations.index')->with('success','specialization updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization)
    {
        $specialization->delete();
        return redirect()->back()->with('success','specialization deleted successfully');
    }
}
