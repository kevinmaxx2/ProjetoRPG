<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    public function login(Request $request)
    {
        $credentials = $request->validated([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenarete();

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
