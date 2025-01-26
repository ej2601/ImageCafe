<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input id="name" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" class="text-white" />
            <x-text-input id="username" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-500" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <!-- Password Strength Indicator -->
        <div id="password-strength" class="mt-4 text-sm">
            <!-- Password strength feedback will be dynamically added here using JavaScript -->
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-400 hover:text-white" href="{{ url('/') }}">
                {{ __('Go to Home') }}
            </a>

            <a class="underline text-sm text-gray-400 hover:text-white" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-purple-600 hover:bg-purple-700 text-white">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Include JavaScript for real-time username validation and password strength -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');

            passwordInput.addEventListener('input', function () {
                const strength = getPasswordStrength(passwordInput.value);
                passwordStrength.innerHTML = `<p class="${strength.class}">${strength.message}</p>`;
            });

            function getPasswordStrength(password) {
                let strength = { message: 'Weak password', class: 'text-red-500' };
                if (password.length >= 8) {
                    strength.message = 'Moderate password';
                    strength.class = 'text-yellow-500';
                }
                if (password.length >= 12 && /[^a-zA-Z]/.test(password)) {
                    strength.message = 'Strong password';
                    strength.class = 'text-green-500';
                }
                return strength;
            }
        });
    </script>
</x-guest-layout>
