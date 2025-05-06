<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        // Create a query builder
        $query = User::orderBy('id', 'desc');
        
        // Apply search if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Get paginated results
        $users = $query->paginate(5);
        
        return view('admin.users.index', compact('users'));
    }



    public function create()
    {

    }


    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6', // Password confirmation is not required in the form
    ]);

    // Prepare the data for saving
    $userData = $request->only(['name', 'email']);
    $userData['password'] = bcrypt($request->password); // Hash the password

    // Create the user
    $user = User::create($userData);

    // Redirect with success message
    return redirect()->route('users.index')->with('success', 'User created successfully.');
}


    public function show(User $user)
    {

    }


    public function edit(User $user)
    {

    }

    public function update(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6', // Password is optional
            'phone' => 'nullable|string|max:20',
        ]);
    
        // Prepare the data for updating
        $userData = $request->only(['name', 'email', 'phone']);
    
        // Update password only if provided
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }
    
        // Update the user
        $user->update($userData);
    
        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        // dd($admin->id);
        $user->delete();
        return redirect()->back()->with('success','User deleted successfully');
    }
}
