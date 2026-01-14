@extends('auth.layout')

@section('content')
    <h3 class="login-title mb-4 text-center">تغيير كلمة المرور</h3>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('auth.reset-password.submit') }}">
        @csrf
        <input type="hidden" name="email" value="{{ old('email') }}">
        <input type="hidden" name="code" value="{{ old('code') }}">
        <div class="form-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور الجديدة" required autofocus>
        </div>
        <div class="form-group mb-3">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="تأكيد كلمة المرور" required>
        </div>
        <button type="submit" class="btn btn-success w-100">تغيير كلمة المرور</button>
    </form>
@endsection
