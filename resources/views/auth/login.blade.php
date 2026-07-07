@extends('layouts.login')

@section('content')
<div class="dvla-login-wrap">
    <div class="dvla-login-card">

        {{-- Logo --}}
        <div class="dvla-login-brand">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/dvla_logo_varB.svg') }}" alt="DVLA" class="dvla-login-logo">
            </a>
        </div>

        <div class="dvla-login-badge">
            <i class="fa-solid fa-key"></i> Default Credentials
        </div>
        <div class="bg-warning p-2 mb-2 text-white fw-bold ">
            <div class="">
                Email: admin@artisanbreach.com
            </div>
            <div class="">
                Password: artisanpass123
            </div>
        </div>


        <h1 class="dvla-login-title">Sign In</h1>
        <p class="dvla-login-sub">Access the vulnerable lab environment.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="dvla-form-group">
                <label class="dvla-form-label">Email</label>
                <input
                    type="text"
                    name="email"
                    class="dvla-form-input @error('email') is-invalid @enderror"
                    placeholder="you@example.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                >
                @error('email')
                    <span class="dvla-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="dvla-form-group">
                <label class="dvla-form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="dvla-form-input @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="current-password"
                >
                @error('password')
                    <span class="dvla-form-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="dvla-login-btn">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Log In
            </button>
        </form>

        <p class="dvla-login-footer-note">
            <a href="{{ url('/') }}"><i class="fa-solid fa-arrow-left me-1"></i>Back to homepage</a>
        </p>
    </div>
</div>
@endsection
