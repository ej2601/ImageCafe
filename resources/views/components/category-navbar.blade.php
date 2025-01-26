@props([
    'categories', // List of categories to display
    'currentCategory' => null, // Currently selected category
])

<div class="category-navbar py-4 rounded-lg mb-4 bg-gray-100 dark:bg-gray-800 flex overflow-x-auto space-x-4 px-4">
    <a href="{{ route('explore') }}"
       class="category-link text-gray-700 dark:text-gray-300 hover:text-purple-600 {{ $currentCategory === null ? 'text-purple-600' : '' }}">
        All
    </a>
    @foreach($categories as $category)
        <a href="{{ route('explore', ['category' => $category->id]) }}"
           class="category-link text-gray-700 dark:text-gray-300 hover:text-purple-600 {{ $currentCategory == $category->id ? 'text-purple-600' : '' }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>
