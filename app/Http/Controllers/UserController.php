<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users|string|email',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = User::create($validate);
        Auth::login($user);
        return response()->json([
            'status' => 'true',
            'message' => 'User registered successfully'
        ]);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($validate)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'token' => $token,
                'message' => 'Login Successful'
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Invalid credentials'
            ]);
        }
    }
    public function profile()
    {
        $userData = Auth::user();
        return response()->json([
            'status' => true,
            'user' => $userData
        ]);
    }
    public function logout()
    {

        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'user logged out successfully'
        ]);
    }
}
