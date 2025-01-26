@props([
    'searchValue' => '',        // Search input value
    'sortOrder' => 'latest',    // Current sorting order (default is 'latest')
    'actionRoute' => 'explore', // The route to submit the form to (default 'explore')
    'customClass' => '',        // Custom classes for the wrapper
    'isMyCreationsPage' => false, 
    ])

<div class="flex items-center my-2 justify-between flex-wrap-reverse gap-4 {{ $customClass }}">
    <!-- Sort Options -->
    <div class="flex items-center gap-4 px-2">
        <label for="sort" class="text-sm font-semibold text-purple-400">Sort By:</label>
        <form method="GET" action="{{ route($actionRoute) }}" id="sortForm" class="relative">
            <select 
                name="sortOrder" 
                id="sort" 
                class="bg-gray-100 text-purple-600 border border-purple-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none transition"
                onchange="document.getElementById('sortForm').submit();">
                <option value="latest" {{ $sortOrder === 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="oldest" {{ $sortOrder === 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="most_liked" {{ $sortOrder === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
            </select>
            <input type="hidden" name="search" value="{{ $searchValue }}">
        </form>
    </div>

    <!-- Bulk Delete Button -->
    @if($isMyCreationsPage)
    <div x-show="selectedImages.length > 0" class="flex items-center gap-2">
        <x-danger-button 
            @click="deleteSelected()" 
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition">
            Delete (<span x-text="selectedImages.length"></span> - selected)
        </x-danger-button>
        <x-secondary-button 
            x-show="selectedImages.length > 0" 
            @click="selectedImages = []" 
            class="bg-gray-100 hover:bg-purple-100 text-purple-600 px-4 py-2 rounded-lg shadow transition">
            Unselect All
        </x-secondary-button>
    </div>
    @endif

    <!-- Search Bar -->
    <div class="flex items-center gap-2">
        <form method="GET" action="{{ route($actionRoute) }}" id="searchForm" class="relative">
            <input
                type="text"
                name="search"
                placeholder="Search by title, category, or prompt..."
                value="{{ $searchValue }}"
                class="bg-gray-100 text-purple-800 border border-purple-600 rounded-lg px-4 py-2 w-80 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
            <button 
                type="submit" 
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-500 transition">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
