<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $apiUsername = config('app.api_username');
        $apiPassword = config('app.api_password');

        if ($request->username !== $apiUsername || $request->password !== $apiPassword) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::firstOrCreate(
            ['email' => $apiUsername.'@api.local'],
            [
                'name' => $apiUsername,
                'password' => Hash::make($apiPassword),
            ]
        );

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
