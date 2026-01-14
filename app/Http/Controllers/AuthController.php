<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->authService->register($request->validated());
        return ApiResponse::success('The verification code has been sent to you, please check your email', 201);
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);
        $user = $this->authService->verifyCode($request->email, $request->code);
        if ($user) {
            $expiresAt = now()->addMonth();
            $token = $user->createToken('auth_Token', ['*'], $expiresAt)->plainTextToken;
            return ApiResponse::successWithData([
                'user' => new UserResource($user),
                'token' => $token,
            ], 'Successfully', 200);
        } else {
            return ApiResponse::error('Invalid or expired verification code', 401);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $result = $this->authService->login($request->email, $request->password);
        if (!$result) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        if (isset($result['error']) && $result['error'] === 'email_not_verified') {
            return ApiResponse::error('The email is not confirmed', 401);
        }
        return ApiResponse::successWithData([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'Login successfully', 200);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return ApiResponse::success('Logout successfully');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $result = $this->authService->forgotPassword($request->email);
        if ($result) {
            return ApiResponse::success('A verification code has been sent to your email.', 200);
        } else {
            return ApiResponse::error('User not found with this email.', 404);
        }
    }

    public function checkCodeForPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);
        $result = $this->authService->checkCodeForPassword($request->email, $request->code);
        if (isset($result['success'])) {
            return ApiResponse::success(null, 200);
        }
        if ($result['error'] === 'user_not_found') {
            return ApiResponse::error('User not found with this email.', 404);
        }
        if ($result['error'] === 'invalid_code') {
            return ApiResponse::error('Invalid verification code.', 401);
        }
        if ($result['error'] === 'expired_code') {
            return ApiResponse::error('Verification code has expired.', 401);
        }
        return ApiResponse::error('invalid.', 400);
    }

    public function resetPassword(Request $request)
    {
        $newpassword = $request->validate([
            'email' => 'required|email',
            'new_password' => "required|string|min:8|confirmed"
        ]);
        $user = $this->authService->resetPassword($request->email, $request->new_password);
        if ($user) {
            return ApiResponse::success("Password has been change", 200);
        }
        return ApiResponse::error("Error", 200);
    }

    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $result = $this->authService->resendVerificationCode($request->email);
        if ($result) {
            return ApiResponse::success('A new verification code has been sent to your email.', 200);
        } else {
            return ApiResponse::error('User not found with this email.', 404);
        }
    }
}
