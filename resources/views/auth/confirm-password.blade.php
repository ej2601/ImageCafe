<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full p-3 border border-gray-700 rounded-md bg-gray-900 text-white focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Button -->
        <div class="flex justify-end mt-4">
            <x-primary-button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
