<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center p-4 sm:p-0 bg-blue-50">
        <div class="w-full sm:max-w-md px-4 sm:px-6 py-6 bg-white shadow-lg sm:rounded-xl border border-blue-100">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/anilao_logo_720x720.png') }}" alt="Municipality of Anilao" class="h-12 sm:h-14">
            </div>
            
            <h2 class="text-center text-lg sm:text-xl font-bold text-gray-800 mb-4">Create Account</h2>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-800 p-3 rounded-lg mb-4 border border-red-200 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Social Registration -->
            <div class="mb-4">
                <button type="button" class="w-full flex items-center justify-center px-3 py-3 sm:py-2 border border-gray-300 rounded-lg shadow-sm bg-white hover:bg-gray-50 transition-all duration-200 text-sm">
                    <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Sign up with Google
                </button>
            </div>

            <div class="flex items-center justify-center my-3">
                <div class="border-t border-gray-200 flex-grow"></div>
                <span class="px-3 text-gray-500 text-xs">OR</span>
                <div class="border-t border-gray-200 flex-grow"></div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                        <input id="name" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="text" name="name" value="{{ old('name') }}" required placeholder="Juan dela Cruz" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
                        <input id="email" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Mobile Number -->
                    <div>
                        <label for="mobile_number" class="block text-xs font-medium text-gray-700 mb-1">Mobile Number</label>
                        <input id="mobile_number" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="text" name="mobile_number" value="{{ old('mobile_number') }}" required placeholder="09XX XXX XXXX" />
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <label for="birthdate" class="block text-xs font-medium text-gray-700 mb-1">Birthdate</label>
                        <input id="birthdate" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="date" name="birthdate" value="{{ old('birthdate') }}" required />
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-xs font-medium text-gray-700 mb-1">Address</label>
                    <input id="address" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="text" name="address" value="{{ old('address') }}" required placeholder="Your complete address" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" class="rounded-lg w-full px-3 py-3 sm:py-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" type="password" name="password_confirmation" required placeholder="••••••••" />
                    </div>
                </div>

                <!-- Terms and Privacy -->
                <div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" class="h-5 w-5 sm:h-4 sm:w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                        </div>
                        <div class="ml-2 text-sm sm:text-xs">
                            <label for="terms" class="text-gray-600">
                                I agree to the <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Terms</a> and <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit" class="w-full flex justify-center py-3 sm:py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Create Account
                    </button>
                </div>
            </form>
            
            <div class="mt-3 text-center text-sm sm:text-xs text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Sign in
                </a>
            </div>
        </div>
        
        <div class="mt-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} Municipality of Anilao
        </div>
    </div>
</x-guest-layout>