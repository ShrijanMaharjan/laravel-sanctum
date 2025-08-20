<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        User::create($validate);
        return response()->json([
            'status' => 'true',
            'message' => 'User registered successfully'
        ]);
    }
}
