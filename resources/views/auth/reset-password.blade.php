<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" 
                          type="email" 
                          name="email" 
                          :value="old('email', $request->email)" 
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" 
                          type="password" 
                          name="password" 
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" 
                          type="password" 
                          name="password_confirmation" 
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="bg-purple-600 hover:bg-purple-700 text-white">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
