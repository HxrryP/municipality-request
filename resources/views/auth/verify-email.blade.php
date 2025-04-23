<x-guest-layout>
    <div class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">
            {{ __('Verify Your Email Address') }}
        </h1>
        <p class="text-sm text-gray-600 leading-relaxed mb-4">
            {{ __('Thank you for signing up! To complete your registration, please verify your email address by clicking the link we sent to your inbox.') }}
        </p>
        <p class="text-sm text-gray-600 leading-relaxed mb-6">
            {{ __('If you didn’t receive the email, don’t worry — you can request another one below.') }}
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-6 p-4 bg-green-50 border border-green-400 text-green-700 rounded">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <!-- Resend Verification Email Form -->
            <form method="POST" action="{{ route('verification.send') }}" class="text-center">
                @csrf
                <x-primary-button class="w-full">
                    {{ __('Send Verification Email') }}
                </x-primary-button>
            </form>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="w-full text-sm font-semibold text-gray-600 hover:text-gray-900 underline">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
