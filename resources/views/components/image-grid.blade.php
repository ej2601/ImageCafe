@props([
'images',
'loading',
'next_page_url',
'selectedImages' => [],
'showCheckbox' => true,
'showTitle' => true,
'customClass' => '',
'showImageViewModal' => false,
'downloadRoute' => route('images.download', ':id')
])

<div class="image-grid-container {{ $customClass }}" x-data="{
    selectedImage: null, currentUserId: @json(auth()->id()),}" @modal-closed.window="console.log($event.detail); const index = images.findIndex(image => image.id === $event.detail.id);
             if (index !== -1) {
                 images[index].likes_count = $event.detail.likes_count;
             }">

         
    <!-- Image Grid -->
    <div
        class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 xl:columns-5 2xl:columns-7 gap-4 p-4"
        id="imageGrid">
        <template x-for="image in images" :key="image.id">
            <div class="break-inside-avoid mb-4">
                <div class="relative group bg-gray-800 rounded-md shadow-md overflow-hidden">
                    <!-- Checkbox for Selection (conditionally rendered) -->
                    @if($showCheckbox)

                    <input
    type="checkbox"
    x-model.number="selectedImages"
    :value="image.id"
    :class="selectedImages.includes(image.id) 
        ? 'opacity-100 bg-purple-600 border-purple-400 ring-2 ring-purple-500' 
        : 'group-hover:opacity-100 opacity-0 bg-purple-300 border-purple-600'"
    class="absolute top-2 left-2 w-5 h-5 rounded-full border transition-all duration-300 z-10 focus:ring-4 focus:ring-purple-500 focus:ring-opacity-50 active:bg-purple-600 active:text-white checked:bg-purple-400 focus:bg-purple-500 checked:focus:bg-purple-400 checked:hover:bg-purple-300"
/>


                    @endif

                    <!-- Image -->
                    <div class="aspect-w-1 aspect-h-1">

                        @if($showImageViewModal)

                        <img
                            :src="'/storage/' + image.image_path"
                            :alt="image.title"
                            @click="
                 selectedImage = { 
                ...image, 
                liked: image.likes.some(like => like.user_id === ($store?.global?.currentUserId ?? currentUserId)) 
            };

                $dispatch('open-modal', 'view-image-modal');
                "
                            class="w-full h-full object-cover cursor-pointer transition-transform duration-300 group-hover:scale-105" />

                        @else

                        <img
                            :src="'/storage/' + image.image_path"
                            :alt="image.title"
                            @click="viewImage(image.id)"
                            class="w-full h-full object-cover cursor-pointer transition-transform duration-300 group-hover:scale-105" />

                        @endif

                    </div>

                    <!-- Heart Icon and Like Count -->
                    <div
                        class="absolute bottom-2 left-2 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <i :class="image.likes.some(like => like.user_id === ($store?.global?.currentUserId ?? currentUserId)) ? 'fas fa-heart text-purple-500' : 'far fa-heart text-purple-400'" class="text-3xl"></i>
                        <span x-text="image.likes_count" class="font-semibold text-purple-100"></span>
                    </div>

                    <!-- Image Title (conditionally rendered) -->
                    @if($showTitle)

                    <div class="p-2">
                        <p class="text-center text-white font-semibold truncate" x-text="image.title"></p>
                    </div>

                    @endif
                </div>
            </div>
        </template>
    </div>


    @if($showImageViewModal)

    @include('components.image-view-modal' )
    
    @endif

    <!-- Loading Spinner -->
    <div x-show="loading" class="flex justify-center mt-4">
        <span class="text-gray-400">Loading more images...</span>
    </div>

</div>