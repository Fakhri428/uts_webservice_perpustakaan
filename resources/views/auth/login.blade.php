<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo"></x-slot>

        <div>
            <h1 style="font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Welcome back</h1>
            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 28px;">Sign in to your Archivist account</p>

            <x-validation-errors style="margin-bottom: 16px;" />

            @session('status')
                <div style="margin-bottom: 16px; padding: 10px 14px; background: #dcfce7; color: #166534; border-radius: 8px; font-size: 13px; font-weight: 500;">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 18px;">
                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@library.org">
                </div>

                <div style="margin-bottom: 8px;">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: var(--text-secondary);">
                        <input id="remember_me" type="checkbox" name="remember" style="width: 15px; height: 15px; border-radius: 4px; accent-color: var(--accent);">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 13px; color: var(--accent); text-decoration: none; font-weight: 500;">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px; font-size: 15px;">
                    Sign In
                </button>

                <p style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-secondary);">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="color: var(--accent); font-weight: 600; text-decoration: none;"> Create one</a>
                </p>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
