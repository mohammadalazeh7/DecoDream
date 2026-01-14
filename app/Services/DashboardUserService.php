<?php

namespace App\Services;

use App\Models\User;

class DashboardUserService
{
    // جلب كل المستخدمين (كويري)
    public function getAll()
    {
        return User::query();
    }

    // جلب مستخدم بالمعرف
    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    // حذف مستخدم
    public function deleteUser(User $user)
    {
        return $user->delete();
    }
}
