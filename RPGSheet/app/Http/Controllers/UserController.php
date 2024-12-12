<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController
{
    public function store(Request $request) {
        $validated = $request->validate([
            'email' => 'bail|required|email|unique:users|max:255',
            'password' => 'bail|required|min:8|confirmed|max:255',
        ]);
        $user = User::create([
            'email' =>validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return response()->json([
            'user'  => $user,
            'message'   => 'User created successfully'
        ], 201);
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

            $validated = $request->validate([
                'email' => 'sometimes|email|unique:users,email,'.$user->id,
                'password' => 'somestimes|min:8|confirmed',
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
