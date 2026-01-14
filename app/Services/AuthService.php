<?php

namespace App\Services;

use App\Models\User;
use App\Mail\VerificationCodeEmail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function register(array $data)
    {
        $otp = rand(100000, 999999);
        $data['OTP'] = $otp;
        $data['verification_code_expires_at'] = now()->addMinutes(10); // الكود صالح 10 دقائق
        $user = User::create($data);
        Mail::to($data['email'])->send(new VerificationCodeEmail($data['OTP']));
        return $user;
    }

    public function verifyCode($email, $code)
    {
        $user = User::whereEmail($email)->first();
        if ($user && $user->OTP == $code) {
            // تحقق من انتهاء صلاحية الكود
            if ($user->verification_code_expires_at && now()->greaterThan($user->verification_code_expires_at)) {
                return null; // الكود منتهي الصلاحية
            }
            // إلغاء الكود بعد استخدامه
            $user->update([
                'email_verified_at' => now(),
                'OTP' => null,
                'verification_code_expires_at' => null,
            ]);
            Mail::to($email)->send(new WelcomeMail($user));
            return $user;
        }
        return null;
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user)
            return null;
        if (is_null($user->email_verified_at))
            return ['error' => 'email_not_verified'];
        if (!Hash::check($password, $user->password))
            return null;
        // مدة صلاحية التوكن حسب ال remember me
        $expiresAt = now()->addMonth();
        $token = $user->createToken('auth_Token', ['*'], $expiresAt)->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
    }

    public function forgotPassword($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }
        $otp = rand(100000, 999999);
        $user->OTP = $otp;
        $user->verification_code_expires_at = now()->addMinutes(10);
        $user->save();
        Mail::to($user->email)->send(new VerificationCodeEmail($otp));
        return true;
    }

    public function checkCodeForPassword($email, $code)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return ['error' => 'user_not_found'];
        }
        if ($user->OTP !== $code) {
            return ['error' => 'invalid_code'];
        }
        if ($user->verification_code_expires_at && now()->greaterThan($user->verification_code_expires_at)) {
            return ['error' => 'expired_code'];
        }
        $user->OTP = null;
        $user->verification_code_expires_at = null;
        $user->save();
        return ['success' => true];
    }

    public function resetPassword($email, $newpassword)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }
        $user->password = $newpassword;
        $user->save();
        return true;
    }

    public function resendVerificationCode($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }
        $otp = rand(100000, 999999);
        $user->OTP = $otp;
        $user->verification_code_expires_at = now()->addMinutes(10);
        $user->save();
        Mail::to($user->email)->send(new VerificationCodeEmail($otp));
        return true;
    }
}
