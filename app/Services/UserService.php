<?php

namespace App\Services;

use App\Models\User;
use App\Mail\UpdateProfileMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateProfile(User $user, array $validatedData)
    {
        $updated = $user->update($validatedData);
        if ($updated) {
            Mail::to($user->email)->send(new UpdateProfileMail());
        }
        return $updated;
    }

    public function changePassword(User $user, $currentPassword, $newPassword)
    {
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }
        return $user->update(['password' => Hash::make($newPassword)]);
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }
}
