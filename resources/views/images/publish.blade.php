<x-modal name="publish-image-modal-{{ $image->id }}" :show="false" maxWidth="lg">

    <form method="POST" action="{{ route('images.publish.store', $image->id) }}">
        @csrf
        <div class="p-6 text-black">
            <!-- Title Field -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', Str::words($image->prompt, 7)) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-gray-300"
                >
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Prompt (Read-Only) -->
            <div class="mb-4">
                <label for="prompt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prompt</label>
                <textarea
                    id="prompt"
                    name="prompt"
                    readonly
                    class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300"
                >{{ $image->prompt }}</textarea>
            </div>

            <!-- Width x Height (Read-Only) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dimensions</label>
                <p class="text-gray-500 dark:text-gray-300">{{ $image->width }} x {{ $image->height }}</p>
            </div>

            <!-- Seed (Read-Only) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seed</label>
                <p class="text-gray-500 dark:text-gray-300">{{ $image->seed }}</p>
            </div>

            <!-- Categories (Multiple Select) -->
            <div class="mb-4">
                <label for="categories" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categories</label>
                <select
                    id="categories"
                    name="category_ids[]"
                    multiple
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-gray-300"
                >
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, old('category_ids', $image->category_ids ?? [])) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Downloadable Toggle -->
            <div class="mb-4 flex items-center">
                <label for="can_download" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Allow Download</label>
                <input
                    type="checkbox"
                    id="can_download"
                    name="can_download"
                    class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500"
                    {{ old('can_download', $image->can_download) ? 'checked' : '' }}
                >
            </div>

            <!-- Hide Prompt Toggle -->
            <div class="mb-4 flex items-center">
                <label for="hide_prompt" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Hide Prompt</label>
                <input
                    type="checkbox"
                    id="hide_prompt"
                    name="hide_prompt"
                    class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500"
                    {{ old('hide_prompt', $image->hide_prompt) ? 'checked' : '' }}
                >
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md shadow-sm hover:bg-purple-700">
                    Publish
                </button>
            </div>
        </div>
    </form>
</x-modal>
