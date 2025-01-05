<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Support\Facades\Log;

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
            Log::info('Logout process started', ['user_id' => $request->user()->id ?? 'No User']);

            if (EnsureFrontendRequestAreStateful::fromFrontend($request)) {
                Auth::guard('web')->logout();
                $request->session()->invalidated();
                $request->session()->regenerateToken();
            } else {
                $request->user()->currentAcessToken()->delete();
            }

            Log::info('Logout process completed');
            return response()->json(['message' => 'Logged out sucessfully'], 200);
        }
}
