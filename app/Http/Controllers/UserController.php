<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }



    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,client',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['msg' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,client',
        ]);

        try {
            // Update fields except password
            $user->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'role' => $request->role,
            ]);

            // Update password only if provided
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['msg' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['msg' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }
}
