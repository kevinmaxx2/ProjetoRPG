<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login sucessfull',
                'user' => Auth::user()
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
        public function logout(Request $request) 
        {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Loggerd out sucessfully']);
        }
}
