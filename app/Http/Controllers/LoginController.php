<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $expiresAt = now()->addMinutes(1);
        $tokenResult = $user->createToken('api-token');
        $user->tokens()->latest()->first()->update(['expires_at' => $expiresAt]);

        return response()->json([
            'user'       => $user,
            'token'      => $tokenResult->plainTextToken,
            'expires_at' => $expiresAt->toDateTimeString(),
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $user = Auth::user();

        $validToken = $user->tokens()
            ->where('name', 'api-token')
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();

        if ($validToken) {
            return response()->json([
                'user'       => $user,
                'token'      => $validToken->plainTextToken ?? $validToken->token,
                'expires_at' => $validToken->expires_at->toDateTimeString(),
            ]);
        }

        $expiresAt = now()->addMinutes(1);
        $tokenResult = $user->createToken('api-token');
        $user->tokens()->latest()->first()->update(['expires_at' => $expiresAt]);

        return response()->json([
            'user'       => $user,
            'token'      => $tokenResult->plainTextToken,
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }
}
