<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "name" => "required",
            "password" => "required"
        ]);

        $user = User::where('name', $request->name)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(['error' => 'Invalid credentials'], 400);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response(["token" => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response(null, 204);
    }
}
