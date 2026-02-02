<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:4'
        ]);

        User::create([
            'username' => $req->username,
            'password' => Hash::make($req->password),
        ]);

        return response()->json([
            'message' => 'Register success'
        ]);
    }

    public function login(Request $req)
    {
        $user = User::where('username', $req->username)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                'message' => 'Login failed'
            ], 401);
        }

        return response()->json([
            'message' => 'Login success',
            'user' => $user
        ]);
    }
}
