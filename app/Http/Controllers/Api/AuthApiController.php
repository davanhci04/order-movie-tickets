<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends BaseApiController
{
    /**
     * Register a new user.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->sendResponse([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 'User registered successfully', 201);
        } catch (\Exception $e) {
            return $this->sendServerError('Registration failed');
        }
    }

    /**
     * Login user.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendUnauthorized('Invalid credentials');
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Get user profile.
     */
    public function profile(): JsonResponse
    {
        if (!Auth::check()) {
            return $this->sendUnauthorized('Authentication required');
        }

        $user = Auth::user();
        $user->load(['ratings.movie', 'comments.movie']);

        return $this->sendResponse($user, 'Profile retrieved successfully');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return $this->sendUnauthorized('Authentication required');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = Auth::user();
            $user->update($request->only(['name', 'email']));

            return $this->sendResponse($user, 'Profile updated successfully');
        } catch (\Exception $e) {
            return $this->sendServerError('Profile update failed');
        }
    }

    /**
     * Logout user.
     */
    public function logout(): JsonResponse
    {
        if (!Auth::check()) {
            return $this->sendUnauthorized('Authentication required');
        }

        Auth::user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'Logout successful');
    }

    /**
     * Refresh token.
     */
    public function refresh(): JsonResponse
    {
        if (!Auth::check()) {
            return $this->sendUnauthorized('Authentication required');
        }

        $user = Auth::user();
        
        // Revoke current token
        $user->currentAccessToken()->delete();
        
        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Token refreshed successfully');
    }
}