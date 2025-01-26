<x-app-layout>
    <!-- Main Wrapper -->
    <div x-data="imageGenerator()" class="flex flex-col flex-1 overflow-auto md:flex-row bg-cover bg-gray-100 dark:bg-gray-900" >

        @include('images.sidebar')

        @include('images.display-board')

    </div>

    <script>
        window.imageGenerateRoute = @json(route('image.generate'));
    </script>

</x-app-layout>