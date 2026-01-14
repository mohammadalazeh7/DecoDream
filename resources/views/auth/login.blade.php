@extends('auth.layout')
@section('content')
    <h2 class="login-title">Login</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Enter Email Address..."
                value="{{ old('email') }}" required>
        </div>
        <div class="mb-3 position-relative">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3">
                <i class="fas fa-eye-slash" id="togglePassword"></i>
            </span>
        </div>
        <button type="submit" class="btn btn-login">Login</button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('auth.forgot-password') }}" class="btn btn-secondary rounded-pill flex-grow-1">Forgot your
            password?</a>
    </div>
@endsection
@section('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    </script>
@endsection
