<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private readonly TokenService $tokenService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $login = $request->validated();

        $user = User::where('email', $login['email'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $this->tokenService->createToken($user);

        return response()->json([
            'token' => $token,
            'message' => 'Login successful',
        ]);
    }

    public function getToken(): JsonResponse
    {
        $user = auth()->user();
        $token = $this->tokenService->createToken($user);

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    /**
     * Handle logout and revoke token.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $token = $request->user()->currentAccessToken();

            if (!$token) {
                return response()->json(['error' => 'No active token found'], 400);

            }

            $token->delete();

            return response()->json(['message' => 'Logout successful']);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to logout',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
