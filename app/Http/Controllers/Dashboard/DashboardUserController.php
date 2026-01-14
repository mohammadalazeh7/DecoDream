<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DashboardUserService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrderResource;

class DashboardUserController extends Controller
{
    protected $userService;
    protected $orderService;

    public function __construct(DashboardUserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    // عرض كل المستخدمين مع البحث بالاسم أو الإيميل
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->paginate(10)->appends($request->except('page'));
        return view('admin.users.index', compact('users'));
    }

    // جلب الطلبات الخاصة بمستخدم معين
    public function orders($userId)
    {
        $orders = $this->orderService->getUserOrders($userId);
        return view('admin.users.orders', [
            'orders' => $orders,
            'user' => User::findOrFail($userId)
        ]);
    }

    // حذف مستخدم
    public function destroy($id)
    {
        $user = $this->userService->getUserById($id);
        $this->userService->deleteUser($user);
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}