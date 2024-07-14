@extends('layouts.app')

@section('css')
<style>
    .alert.alert-success {
        padding: 0.5rem !important;
        font-size: 15px !important;
    }
</style>
@endsection

@section('content')
<div class="card-body p-5">
    <h1 class="fs-4 card-title fw-bold mb-4">{{ __('Reset Sandi') }}</h1>
    
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="needs-validation" autocomplete="off">
        @csrf
        <div class="mb-3">
            <label class="mb-2 text-muted" for="email">{{ __('Email') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Send Password Reset Link') }}
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
