<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function loginAdmin(LoginRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::where('username', $data['username'])->first();

        if ($admin && Hash::check($data['password'], $admin->password)) {
            $token = $admin->createToken('admin-token')->plainTextToken;

            return response()->json([
                "status" => true,
                "message" => "Welcome Back Again.",
                "data" => [
                    "admin" => $admin,
                    "token" => $token,
                ],
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Invalid credentials."
        ], 401);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logged out successfully."
        ]);
    }
}
