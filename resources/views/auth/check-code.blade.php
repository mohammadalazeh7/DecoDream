@extends('auth.layout')

@section('content')
    <h3 class="login-title mb-4 text-center">Enter verification code</h3>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('auth.check-code.submit') }}">
        @csrf
        <input type="hidden" name="email" value="{{ old('email') }}">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="code" name="code" placeholder="Check Code" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100">Check</button>
    </form>
@endsection
