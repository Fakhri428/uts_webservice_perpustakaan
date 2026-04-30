<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo"></x-slot>

        <div>
            <h1 style="font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Create account</h1>
            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 28px;">Join Archivist as a library member</p>

            <x-validation-errors style="margin-bottom: 16px;" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label class="form-label" for="name">Full Name</label>
                    <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Dr. Julian Vance">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@library.org">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters">
                </div>

                <div style="margin-bottom: 24px;">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password">
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer; font-size: 13px; color: var(--text-secondary); line-height: 1.5;">
                            <input name="terms" id="terms" type="checkbox" required style="margin-top: 2px; width: 15px; height: 15px; accent-color: var(--accent);">
                            <span>
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" style="color: var(--accent); text-decoration: none; font-weight: 500;">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" style="color: var(--accent); text-decoration: none; font-weight: 500;">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </span>
                        </label>
                    </div>
                @endif

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px; font-size: 15px;">
                    Create Account
                </button>

                <p style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-secondary);">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color: var(--accent); font-weight: 600; text-decoration: none;"> Sign in</a>
                </p>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
