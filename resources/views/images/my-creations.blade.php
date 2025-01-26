<x-app-layout mainBodyClass="h-screen">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Creations') }}
        </h2>
    </x-slot>

    <div x-data="ImageGrid.imageManager()" x-ref="imageGrid" class="pb-8 px-4 flex-column bg-black w-screen h-full overflow-y-scroll text-white">
        
        <!-- Header Section with Sort and Search -->
        <div class="flex-column h-auto items-center bg-black py-4 justify-between mb-6 sticky top-0 z-20">
            <!-- Sort Options -->
            <x-sort-search 
    :searchValue="request('search')" 
    :sortOrder="request('sortOrder', 'latest')" 
    :actionRoute="'images.index'"
    :isMyCreationsPage=true
    customClass=""
/>
        </div>

     <!-- Image Grid -->
     <x-image-grid 
    :images="$images" 
    :showTitle="false" 
    customClass="custom-page-without-checkbox"
/>
</div>
    </div>

    <script>
    const imageData = @json($images->items());
    const nextPageUrl = @json($images->nextPageUrl());
    const sortOrder = "{{ request('sortOrder', 'latest') }}";
    const bulkDeleteRoute = "{{ route('images.bulk-delete') }}";
</script>

</x-app-layout>

