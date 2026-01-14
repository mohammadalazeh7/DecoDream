<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardLoginRequest;
use App\Mail\VerificationCodeEmail;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthDashboardController extends Controller
{
    //
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(DashboardLoginRequest $request)
    {
        // $employee = Employee::where('email', $request->email)->first();
        $employee = Employee::with('role')->where('email', $request->email)->first();

        if ($employee && Hash::check($request->password, $employee->password)) {
            Auth::guard('employee')->login($employee);
            return $this->redirectBasedOnRole($employee->role_id);
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->withInput($request->only('email'));

    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    private function redirectBasedOnRole($roleId)
    {
        $roleRoutes = [
            1 => 'employees.index',
            2 => 'products.index',
            3 => 'orders.index',
            4 => 'invoices.index',
            5 => 'complaints.index',
        ];

        $defaultRoute = 'login';

        return redirect()->route($roleRoutes[$roleId] ?? $defaultRoute);
    }
    public function forgotPasswordWeb(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $employee = Employee::where('email', $request->email)->first();

        if (!$employee) {
            return back()->with('error', 'Employee is not present');
        }

        if ($employee->role_id != 1) {
            return back()->with('error', 'You are not authorized to reset your password');
        }

        $code = rand(100000, 999999);
        $employee->reset_code = $code;
        $employee->reset_code_expires_at = now()->addMinutes(15);
        $employee->save();

        \Mail::to($employee->email)->send(new VerificationCodeEmail($code));

        // الانتقال مباشرة لصفحة إدخال الكود مع تمرير الإيميل
        return redirect()->route('auth.check-code')->withInput(['email' => $request->email]);
    }
    public function checkCodeWeb(Request $request)
    {
        $request->validate([
            // 'email' => 'required|email',
            'code' => 'required'
        ]);

        $employee = Employee::where('email', $request->email)->first();

        // if (!$employee) {
        //     return back()->with('error', 'Employee is not present')->withInput(['email' => $request->email]);
        // }

        if ($employee->reset_code !== $request->code || !$employee->reset_code_expires_at || now()->gt($employee->reset_code_expires_at)) {
            return back()->with('error', 'The code is invalid or expired')->withInput(['email' => $request->email]);
        }

        // إذا تحقق الكود، انتقل لصفحة إعادة تعيين كلمة المرور مع تمرير الإيميل والكود
        return redirect()->route('auth.reset-password')->withInput(['email' => $request->email, 'code' => $request->code]);
    }
    public function resetPasswordWeb(Request $request)
    {
        $request->validate([
            // 'email' => 'required|email',
            // 'code' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $employee = Employee::where('email', $request->email)->first();

        // if (!$employee) {
        //     return back()->with('error', 'الموظف غير موجود')->withInput(['email' => $request->email, 'code' => $request->code]);
        // }

        // if ($employee->reset_code !== $request->code || !$employee->reset_code_expires_at || now()->gt($employee->reset_code_expires_at)) {
        //     return back()->with('error', 'الكود غير صحيح أو منتهي الصلاحية')->withInput(['email' => $request->email, 'code' => $request->code]);
        // }

        // تغيير كلمة المرور
        $employee->password = bcrypt($request->password);
        // حذف الكود بعد الاستخدام
        $employee->reset_code = null;
        $employee->reset_code_expires_at = null;
        $employee->save();

        return redirect()->route('login')->with('status', 'Your password has been changed successfully! You can log in now.');
    }


}







