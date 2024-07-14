@extends('layouts.app')

@section('content')
<div class="card-body p-5">
    <h1 class="fs-4 card-title fw-bold mb-4">{{ __('Reset Password') }}</h1>
    <form method="POST" action="{{ route('password.update') }}" class="needs-validation" autocomplete="off">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label class="mb-2 text-muted" for="email">{{ __('Email') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <div class="mb-2 w-100">
                <label class="text-muted" for="password">{{ __('Password') }}</label>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <div class="mb-2 w-100">
                <label class="text-muted" for="password">{{ __('Konfirmasi Password') }}</label>
            </div>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" required>
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</div>
<div class="card-footer py-3 border-0">
    <div class="text-center">
        {{ __('Sudah punya akun?') }} 
        <a class="text-dark" href="{{ route('login') }}">
            {{ __('Login') }}
        </a>
    </div>
</div>
@endsection
