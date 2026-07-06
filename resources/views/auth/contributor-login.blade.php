@extends('layouts.login')

@section('content')

<div class="container vertical-center">
    <div class="row bg-customlight p-5 shadow-lg rounded">

        <div class="auth-logo text-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo_footer.png') }}" class="img-fluid" alt="" style="max-height: 100px;">
            </a>
        </div>

        <h1 class="auth-title text-center text-white">{{ __('Contributor Portal') }}</h1>
        <p class="text-center text-muted small mb-4">For accounts migrated from the v1 system</p>

        <div class="mt-2">
            <form class="login_box" method="POST" action="{{ route('contributor.login.post') }}">
                @csrf

                <div class="form-group position-relative mb-4">
                    <input type="text"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Enter your Email"
                           name="email"
                           value="{{ old('email') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group position-relative mb-4">
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button class="btn btn-custom btn-primary shadow">{{ __('Log in') }}</button>
            </form>

            <div class="text-center mt-4">
                <a class="text-muted small" href="{{ route('login') }}">Staff login &rarr;</a>
            </div>
        </div>
    </div>
</div>

@endsection
