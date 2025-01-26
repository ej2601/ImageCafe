<form id="image-generation-form" @submit.prevent="generateImage" x-ref="imageForm" class="md:sticky md:top-0 overflow-auto w-full md:w-1/4 bg-black p-6 space-y-6  bg-opacity-95 dark">
    @csrf

    <!-- Width and Height Inputs -->
    <div x-data="{ width: 576, height: 1024 }">
        <x-input-label class="block text-sm font-bold mb-2" for="width">Width</x-input-label>
        <x-text-input
            type="number"
            x-model="width"
            min="256"
            max="1024"
            step="8"
            placeholder="Width"
            class="w-full p-2 mb-3 bg-gray-700 text-white border border-gray-600 rounded-md"
            name="width"
            required>
        </x-text-input>

        <x-input-label class="block text-sm font-bold mb-2" for="height">Height</x-input-label>
        <x-text-input
            type="number"
            x-model="height"
            min="256"
            max="1024"
            step="8" 
            placeholder="Height"
            class="w-full p-2 mb-3 bg-gray-700 text-white border border-gray-600 rounded-md"
            name="height"
            required>
        </x-text-input>

        <p class="text-sm text-gray-400 mt-2">Predefined Sizes:</p>
        <div class="flex space-x-2 mt-1 flex-wrap">
            <x-secondary-button @click="width = 1024; height = 1024" class="bg-gray-100 hover:bg-gray-700 hover:text-white transition p-2 rounded-md text-sm my-2">1024x1024</x-secondary-button>
            <x-secondary-button @click="width = 1024; height = 576" class="bg-gray-100 hover:bg-gray-700 hover:text-white transition p-2 rounded-md text-sm my-2">1024x576</x-secondary-button>
            <x-secondary-button @click="width = 576; height = 1024" class="bg-gray-100 hover:bg-gray-700 hover:text-white transition p-2 rounded-md text-sm my-2">576x1024</x-secondary-button>
            <x-secondary-button @click="width = 512; height = 512" class="bg-gray-100 hover:bg-gray-700 hover:text-white transition p-2 rounded-md text-sm my-2">Default (512x512)</x-secondary-button>
        </div>
    </div>

    <!-- Text Prompt Box -->
    <div>
        <x-input-label class="block text-sm font-bold mb-2" for="prompt">Text Prompt</x-input-label>
        <textarea x-ref="prompt" rows="4" class="w-full p-2 bg-gray-700 text-white border border-gray-600 rounded-md focus:border-purple-500" placeholder="Describe the image you want..." name="prompt" required>close up, a gorgeous warrior woman looking at the viewer in the magic jungle, golden armour, long golden hair, detailed eyes and face, stunning face, 8k resolution concept art intricately detailed hyperdetailed, complementary colors, hyperrealism,  fantastical sunshine rays, light dust, glowing neon</textarea>
    </div>

    <!-- Seed Selection -->
    <div x-data="{ seedOption: 'custom', customSeed: '1' }">
        <x-input-label class="block text-sm font-bold mb-2" for="seed">Seed Selection</x-input-label>
        <select x-model="seedOption" class="w-full p-2 bg-gray-700 text-white border border-gray-600 rounded-md" name="seed_option">
            <option value="random">Random Seed</option>
            <option value="custom">Custom Seed</option>
        </select>
        <x-text-input x-show="seedOption === 'custom'" name="custom_seed" type="number" x-model="customSeed" placeholder="Enter custom seed" class="w-full p-2 mt-2 bg-gray-700 text-white border border-gray-600 rounded-md"></x-text-input>
    </div>

    <!-- Generate Image Button -->
    <button
        type="submit"
        x-bind:disabled="showTimer"
        class="w-full bg-purple-600 p-3 mt-4 rounded-md hover:bg-purple-700 text-white font-semibold transition-all duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:hover:bg-gray-400">
        <span x-show="!showTimer">Generate Image</span>
        <span x-show="showTimer">Generating...</span>
    </button>
</form>