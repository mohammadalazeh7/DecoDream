<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show()
    {
        $user = Auth::user();
        $user = $this->userService->getUserById($user->id);
        return ApiResponse::successWithData([
            'user' => new UserResource($user),
        ], 'User retrieved successfully', 200);
    }

    public function update(UpdateUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();
        $updated = $this->userService->updateProfile($user, $validatedData);
        if (!$updated) {
            return ApiResponse::error('Profile update failed', 400);
        }
        return ApiResponse::success('Profile updated successfully', 200);
    }

    public function changePass(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
        $changed = $this->userService->changePassword($user, $request->current_password, $request->new_password);
        if (!$changed) {
            return ApiResponse::error('Your current password does not match', 401);
        }
        return ApiResponse::success('password changed successfully', 200);
    }

    public function destroy()
    {
        $user = Auth::user();
        $this->userService->deleteUser($user);
        return ApiResponse::success('User deleted successfully', 200);
    }
}
