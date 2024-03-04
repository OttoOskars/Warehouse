<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Exception;

class AdminController extends Controller
{
    public function registerAdmin(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
            ]);

            // Retrieve the admin role
            $adminRole = Role::where('name', 'admin')->first();
            if (!$adminRole) {
                return response()->json(['error' => 'Admin role not found.'], 500);
            }

            // Create a new user with admin role
            $user = new User();
            $user->name = $validatedData['name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->role_id = 1; // Assign the role ID to the user
            $user->save();

            // Optionally, return a response indicating success
            // After saving the admin user
            return response()->json(['message' => 'Admin registered successfully', 'name' => $user->name]);
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            // Attempt to authenticate the user
            if (auth()->attempt($credentials)) {
                // Authentication passed, user is admin
                return response()->json(['message' => 'Admin login successful', 'name' => auth()->user()->name]);
            } else {
                // Authentication failed
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
