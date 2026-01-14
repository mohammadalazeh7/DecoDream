@extends('auth.layout')

@section('content')
    <h2 class="login-title">Enter email for verification</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('auth.forgot-password.submit') }}">
        @csrf
        <div class="form-group mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required autofocus>
            @error('email')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Send code</button>
    </form>
@endsection
