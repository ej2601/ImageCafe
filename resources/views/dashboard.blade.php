<x-app-layout mainBodyClass="h-screen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Explore Images') }}
        </h2>
    </x-slot>

    <div x-data="ImageGrid.imageManager()" x-ref="imageGrid" class="pb-8 px-4 flex-column bg-white w-screen h-full overflow-y-scroll text-white" data-images="@json($images->items())"
    data-next-page-url="@json($images->nextPageUrl())"
    data-sort-order="{{ request('sortOrder', 'latest') }}">

        <!-- Header Section with Sort and Search -->
        
        <div class="flex-column h-auto items-center bg-white py-1 justify-between sticky top-0 z-20 flex-wrap-reverse">

            <!-- Category Navbar -->
            <x-category-navbar :categories="$categories" :current-category="request('category')" />
      
            
            <!-- Sort Options -->
            <x-sort-search 
    :searchValue="request('search')" 
    :sortOrder="request('sortOrder', 'latest')" 
    customClass=""
/>
         
        </div>


        <!-- Image Grid -->
        <x-image-grid 
    :images="$images" 
    :showTitle="false"  
    :showCheckbox="false"
    :showImageViewModal="true"
    customClass="custom-page-without-checkbox"
/>

        
<script>
    const imageData = @json($images->items());
    const nextPageUrl = @json($images->nextPageUrl());
    const sortOrder = "{{ request('sortOrder', 'latest') }}";
    const bulkDeleteRoute = "{{ route('images.bulk-delete') }}";
</script>

    </x-app-layout>
