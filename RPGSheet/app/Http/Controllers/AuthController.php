<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authtoken')->plainTextToken;

            return response()->json([
                'message' => 'Login sucessful',
                'user' => $user,
                'token' => $token
            ], 200);
        }
        throw ValidationExcepton::withMessages([
            'email' => ['The provided creedntials are incorrect.'],
        ]);
    }
        public function logout(Request $request) 
        {
            Auth::guard('web')->logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Loggerd out sucessfully']);
        }
}
