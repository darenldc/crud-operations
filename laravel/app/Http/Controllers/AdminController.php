<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(['username' => ['required'], 'password' => ['required']]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $token = Auth::guard('admin')->user()->createToken('auth_token')->plainTextToken;

            return response(['access_token' => $token, 'token_type' => 'Bearer'], 200);
        }

        return response(['error' => 'Invalid credentials.'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Logout successful.'], 200);
    }
}
