<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'email' => 'bail|required|email|unique:users|max:255',
                'password' => 'bail|required|min:8|confirmed|max:255',
                
            ]);
    
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
    
            return response()->json([
                'message' => 'User created successfully',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    
                ]
            ], 201);
    
        } catch (ValidationException $e) {
            Log::error('User creation failed: Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('User creation failed: Unexpected error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], 500);
        }
    }
    public function show($id) {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'User not found'
            ], 404);
        }
    }
    public function update(Request $request, $id) {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validated([
                'email' => 'sometimes|email|unique:users,email,'.$user->id,
                'password' => 'sometimes|min:8|confirmed',
            ]);

            if(isset($validated['email'])) {
                $user->email = $validated['email'];
            }
            if(isset($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();
            return response()->json([
                'user'  => $user,
                'message'   => 'User updated sucessfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'User not found'
            ], 404);
        }
    }
    public function destroy($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message'   => 'User deleted sucessfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
}
