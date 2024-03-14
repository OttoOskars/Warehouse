<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Exception;
use Closure;

class AdminController extends Controller
{
    public function registerAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
            ]);

            $adminRole = Role::where('name', 'admin')->first();
            if (!$adminRole) {
                return response()->json(['error' => 'Admin role not found.'], 500);
            }

            $user = new User();
            $user->name = $validatedData['name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->role_id = 1;
            $user->save();

            return response()->json(['message' => 'Admin registered successfully', 'name' => $user->name]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                return response()->json([
                    'message' => 'Login successful', 
                    'name' => $user->name, 
                    'role' => $user->role_id,
                ]);
            } else {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
                'role' => 'required|integer',
            ]);

            $user = new User();
            $user->name = $validatedData['name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->role_id = $validatedData['role'];
            $user->save();

            return response()->json(['message' => 'User created successfully', 'name' => $user->name]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handle($request, Closure $next)
    {
        if (auth()->user()->role_id == 2) {
            return redirect('worker-dashboard');
        } elseif (auth()->user()->role_id == 3) {
            return redirect('organizer-dashboard');
        }

        return $next($request);
    }

    public function fetchUsers()
    {
        try {
            $users = User::with('role')
                        ->whereHas('role', function ($query) {
                            $query->whereIn('name', ['worker', 'organizer']);
                        })
                        ->get();

            $users->transform(function ($user) {
                $user->role_name = $user->role->name;
                return $user;
            });

            return response()->json($users);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'role_id' => 'required|integer',
            ]);

            $user->update($validatedData);
            return response()->json(['message' => 'User updated successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
