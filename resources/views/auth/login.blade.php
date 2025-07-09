<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" 
                          class="block mt-2 w-full rounded-lg border-gray-300 bg-white/50 backdrop-blur-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
                          autocomplete="username"
                          placeholder="Enter your email address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password" 
                          class="block mt-2 w-full rounded-lg border-gray-300 bg-white/50 backdrop-blur-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200"
                          type="password"
                          name="password"
                          required 
                          autocomplete="current-password"
                          placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 transition-colors" 
                       name="remember">
                <span class="ms-3 text-sm text-gray-600 font-medium">{{ __('Remember me for 30 days') }}</span>
            </label>
        </div>

        <!-- Login Button and Forgot Password -->
        <div class="space-y-4">
            <x-primary-button class="w-full justify-center py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl rounded-lg font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Sign In to Dashboard') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                       href="{{ route('password.request') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.639 2.755C5.684 11.061 4 9.165 4 7a6 6 0 1112 0z"></path>
                        </svg>
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </div>

        <!-- Demo Credentials -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="text-sm font-semibold text-blue-800 mb-3">Demo Credentials - Click to Auto-Fill:</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                <button type="button" 
                        onclick="fillDemoCredentials('admin@waterbilling.com', 'password123')"
                        class="flex items-center justify-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-800 text-xs font-medium rounded-lg transition-colors border border-red-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Admin User
                </button>
                
                <button type="button" 
                        onclick="fillDemoCredentials('manager@waterbilling.com', 'manager123')"
                        class="flex items-center justify-center px-3 py-2 bg-purple-100 hover:bg-purple-200 text-purple-800 text-xs font-medium rounded-lg transition-colors border border-purple-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                    </svg>
                    Manager User
                </button>
                
                <button type="button" 
                        onclick="fillDemoCredentials('staff@waterbilling.com', 'staff123')"
                        class="flex items-center justify-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-medium rounded-lg transition-colors border border-blue-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Staff User
                </button>
                
                <button type="button" 
                        onclick="fillDemoCredentials('reader@waterbilling.com', 'reader123')"
                        class="flex items-center justify-center px-3 py-2 bg-green-100 hover:bg-green-200 text-green-800 text-xs font-medium rounded-lg transition-colors border border-green-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Meter Reader
                </button>
            </div>
            <p class="text-xs text-blue-600 mt-2 text-center">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Click any button above to automatically fill login credentials
            </p>
        </div>
    </form>

    <script>
        function fillDemoCredentials(email, password) {
            // Fill the email and password fields
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            
            // Add a subtle animation to show the fields were filled
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            
            [emailField, passwordField].forEach(field => {
                field.style.backgroundColor = '#dbeafe';
                field.style.transform = 'scale(1.02)';
                
                setTimeout(() => {
                    field.style.backgroundColor = '';
                    field.style.transform = '';
                }, 300);
            });
            
            // Focus on the submit button to indicate ready to login
            setTimeout(() => {
                const submitButton = document.querySelector('button[type="submit"], .primary-button');
                if (submitButton) {
                    submitButton.focus();
                }
            }, 400);
        }
    </script>
</x-guest-layout>
