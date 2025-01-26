<!-- Right Display Board -->
<style>
    .bg-wood-pattern {
        background-image: url('{{ asset('images/background.jpeg') }}');
    }
</style>

<div class="w-full md:w-3/4  p-6 flex justify-center items-center bg-wood-pattern bg-cover overflow-auto">

    <p x-show="!isGenerating" class="text-gray-500 text-xl">Waiting for image generation... </p>

    <!-- Image Display Card -->
    <div x-show="isGenerating" class="w-full h-full max-w-2xl min-h-96 bg-white shadow-lg rounded-lg flex flex-col justify-between overflow-auto relative transition-all duration-300 hover:shadow-2xl">

        <!-- Top Section: Image or Loading Effect -->
        <div class="flex justify-center items-center relative h-5/6 bg-gray-200 rounded-t-lg">

            <!-- Display the generated image, maintaining its aspect ratio -->
            <div x-show="generatedImageUrl" class="w-full h-full flex justify-center items-center">
                <img :src="generatedImageUrl" class="object-contain w-full h-full" alt="Generated Image">
            </div>

            <!-- Running Seconds -->
            <div x-show="showTimer" class="absolute top-4 right-4 text-gray-700 bg-white bg-opacity-70 px-3 py-1 rounded-full shadow">
                <span x-text="`${seconds}s`"></span>
            </div>
        </div>

        <!-- Bottom Section: Action Buttons -->
        <div x-show="generatedImageUrl" class="h-1/6 flex justify-around items-center bg-gradient-to-r from-gray-300 via-gray-400 to-gray-500 rounded-b-lg transition-all duration-300 hover:from-gray-400 hover:via-gray-500 hover:to-gray-600">

            <a
                x-show="generatedImageUrl"
                :href="'{{ route('image.show', '') }}/' + imageId"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md transform hover:scale-105 transition-transform">
                Open
            </a>

            <!-- Delete Form -->
            <button
                @click="deleteImage('{{ route('images.destroy', ':id') }}'.replace(':id', imageId))"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg shadow-md transform hover:scale-105 transition-transform">
                Delete
            </button>

        </div>
    </div>
</div>