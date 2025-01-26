 <!-- Modal for Viewing Image -->
 <x-modal
     name="view-image-modal"
     :show="false"
     maxWidth="2xl">

     <div class="flex flex-col md:flex-row w-full h-full" @keydown.escape="console.log('hello'); $dispatch('modal-closed', selectedImage);">
         <!-- Left Section: Display Image -->
         <div class="w-full bg-black flex items-center justify-center p-4">
             <img
                 x-bind:src="selectedImage ? `/storage/${selectedImage.image_path}` : ''"
                 x-bind:alt="selectedImage ? selectedImage.title : 'Image'"
                 class="max-w-full max-h-full object-contain" />
         </div>

         <!-- Right Section: Display Details -->
         <div class="w-full bg-purple-100 text-black dark:bg-gray-900 p-6 flex flex-col space-y-4">

             <!-- Top Bar -->
             <div class="flex items-center justify-between space-x-4 gap-4">
                 <!-- User Info -->
                 <div class="flex items-center space-x-3">
                     <img
                         :src="selectedImage?.user?.profile_image"
                         alt="User Profile"
                         class="w-12 h-12 rounded-full" />
                     <a
                         :href="`{{ route('profile.show', ":id") }}`.replace(':id', selectedImage?.user?.username) "
                         class="font-bold text-gray-800 dark:text-gray-300 hover:text-gray-600"
                         x-text="selectedImage?.user?.name"></a>
                 </div>
                 <!-- Follow Button -->
                 <button
                     x-show="selectedImage?.user?.id !== {{ auth()->id() ?? 'null' }}"
                     @click="followUser(selectedImage?.user?.id, selectedImage)"
                     :class="selectedImage?.user?.is_followed ? 'bg-purple-200 text-purple-800 border-2 border-purple-500' : 'bg-purple-600 text-white border border-transparent'"
                     class="inline-flex items-center px-4 py-2 dark:bg-purple-500 hover:text-white rounded-md font-semibold text-xs dark:text-gray-200 border-double uppercase tracking-widest hover:bg-purple-500 dark:hover:bg-purple-400 focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                     <span x-text="selectedImage?.user?.is_followed ? 'Unfollow -' : 'Follow +'"></span>
                     <!-- <span x-text="selectedImage?.user?.is_followed"></span> -->
                 </button>


             </div>

             <!-- Image Details -->
             <div class="space-y-3 pt-8">

                 <!-- Title and Description -->
                 <div>
                     <h2 class="text-2xl font-bold" x-text="selectedImage?.title"></h2>
                     <p class="mt-2 text-gray-900" x-text="selectedImage?.description || 'No description available'"></p>
                 </div>

                 <!-- Prompt -->
                 <div>
                     <h3 class="text-lg font-semibold mb-2">Prompt</h3>
                     <p class="text-gray-900" x-text="selectedImage?.hide_prompt ? 'Prompt is hidden' : selectedImage?.prompt "></p>
                     <x-secondary-button @click="copyToClipboard(selectedImage?.prompt)" class="mt-3 bg-purple-300 rounded-full hover:bg-purple-700 hover:text-white transition"><i class="far fa-copy font-bold text-sm"></i></x-secondary-button>

                 </div>

                 <!-- Categories -->
                 <div class="mt-4">
                     <h3 class="text-lg font-semibold mb-2 text-purple-500">Categories</h3>

                     <div class="flex flex-wrap gap-2">
                         <!-- Check if the selectedImage has categories -->
                         <template x-if="selectedImage?.categories && selectedImage.categories.length > 0">
                             <template x-for="category in selectedImage?.categories" :key="category.id">
                                 <span
                                     class="px-3 py-1 text-sm rounded-full bg-purple-700 text-white hover:bg-purple-600 transition"
                                     x-text="category.name">
                                 </span>
                             </template>
                         </template>

                         <!-- Show fallback text if no categories are available -->
                         <template x-if="!selectedImage?.categories || selectedImage.categories.length === 0">
                             <span class="text-sm text-gray-500 italic">No categories</span>
                         </template>
                     </div>
                 </div>


                 <!-- Image Details -->
                 <div>
                     <h3 class="text-lg font-semibold mb-2">Details</h3>
                     <div class="grid grid-cols-2 gap-4 text-sm">

                         <div>
                             <p class="text-gray-800 font-semibold">Dimensions: </p>
                             <p class="text-black text-lg" x-text="`${selectedImage?.width} x ${selectedImage?.height}`"></p>
                         </div>

                         <div>
                             <p class="text-gray-800 font-semibold">Created:</p>
                             <!-- Format the date and time -->
                             <p class="text-black text-lg"
                                 x-text="selectedImage?.created_at ">
                             </p>
                         </div>


                     </div>
                 </div>


             </div>

             <!-- Buttons -->
             <div class="flex pt-6">

                 <a x-show="selectedImage?.can_download"
                     :href="`{{ $downloadRoute }}`.replace(':id', selectedImage?.id)"
                     class="bg-purple-300 px-4 py-2 rounded-full mr-4 hover:bg-purple-700 hover:text-white transition">
                     <i class="fas fa-download"></i>
                 </a>

                 <!-- Right Side Like Button -->
                 <div class="flex items-center my-3 md:my-0">
                     <button
                         @click="likeImage(`{{ route('images.like', ':id') }}`.replace(':id', selectedImage?.id), selectedImage)"
                         :class="selectedImage?.liked ? 'text-purple-500' : 'text-purple-400'"
                         class="focus:outline-none transition duration-300">
                         <i :class="selectedImage?.liked ? 'fas fa-heart' : 'far fa-heart'" class="text-4xl"></i>
                     </button>
                     <span x-text="selectedImage?.likes_count" class="ml-2 text-center font-semibold text-lg text-purple-700"></span>
                 </div>




             </div>
         </div>
     </div>
 </x-modal>