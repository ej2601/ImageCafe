<x-app-layout>
    <div x-data="imageViewer" x-init="init(@json($image->likes()->count()), @json($image->likes()->where('user_id', auth()->id())->exists()))" @scroll="handleScroll" class="bg-black md:h-full h-screen w-screen text-white relative overflow-auto">


        <!-- Full Screen Image View -->
        <div class="flex justify-center items-center bg-black">
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Generated Image" class="  object-contain h-full">
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-sm text-gray-400">
            <span>Scroll down for details</span>
        </div>

        <!-- Details Section -->
        <div x-ref="detailsSection" class="mt-8 p-6 bg-gray-900 h-full text-white opacity-0 transition-opacity duration-500 ease-in-out shadow-lg rounded-lg">
            <!-- Image Details -->
            <h2 class="text-2xl font-bold mb-6 border-b border-gray-700 pb-2">Image Details</h2>

            <div class="mb-6">
                <label class="font-semibold">Text Prompt:</label>
                <div class="flex justify-between items-center bg-gray-800 p-3 rounded-md transition duration-300 hover:bg-gray-700">
                    <span class="text-gray-300">{{ $image->prompt }}</span>
                    <x-secondary-button @click="copyToClipboard('{{ $image->prompt }}')" class="bg-gray-100 px-3 py-1 text-sm rounded-md hover:bg-gray-700 hover:text-white transition">Copy</x-secondary-button>
                </div>
            </div>

            <div class="mb-6">
                <label class="font-semibold">Dimensions:</label>
                <span class="text-gray-300">{{ $image->width }} x {{ $image->height }} pixels</span>
            </div>

            <div class="mb-6">
                <label class="font-semibold">Aspect Ratio:</label>
                <span class="text-gray-300">{{ round($image->width / $image->height, 2) }}:1</span>
            </div>

            <div class="mb-6">
                <label class="font-semibold">Seed:</label>
                <span class="text-gray-300">{{ $image->seed ?? 'Random' }}</span>
            </div>

            @if($image->category)
            <div class="mb-6">
                <label class="font-semibold">Category:</label>
                <span class="text-gray-300">{{ $image->category }}</span>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6 flex-wrap-reverse">
                <!-- Left Side Buttons -->
                <div class="flex space-x-4">
                    <!-- Publish/Unpublish Form -->
                    @if(!$image->is_published)
                    <button
                        class="px-4 py-2 bg-purple-600 text-white rounded-md shadow-sm hover:bg-purple-700"
                        x-on:click="$dispatch('open-modal', '{{ 'publish-image-modal-' . $image->id }}')">
                        Publish
                    </button>
                    @include('images.publish', ['image' => $image, 'categories'=> $categories])
                    @else
                    <form action="{{ route('images.unpublish', $image->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-700 transition">
                            Unpublish
                        </button>
                    </form>
                    @endif

                    <!-- Download Button (Direct Link) -->
                    <a href="{{ route('images.download', $image->id) }}" class="bg-blue-600 px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Download
                    </a>

                    <!-- Delete Form -->
                    <form action="{{ route('images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 px-4 py-2 rounded-md hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>

                <!-- Right Side Like Button -->
                <div  class="flex items-center my-3 md:my-0">
                    <button @click="likeImage('{{ route('images.like', $image->id) }}', $data)"
                        :class="liked ? 'text-red-500' : 'text-gray-400'"
                        class="focus:outline-none transition duration-300">
                        <i :class="liked ? 'fas fa-heart' : 'far fa-heart'" class="mx-2 text-4xl"></i>
                    </button>
                    <span x-text="likes_count" class="ml-1 text-center"></span> <!-- Display the like count -->
                </div>
            </div>

        </div>
    </div>


</x-app-layout>