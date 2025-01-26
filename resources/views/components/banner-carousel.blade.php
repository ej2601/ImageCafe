<!-- incomplete -->
<div class="relative w-screen h-screen bg-black">
    <!-- Carousel Structure -->
    <div class="carousel-container h-full w-full flex items-center justify-center bg-opacity-75 bg-gradient-to-r from-purple-500 via-purple-700 to-purple-900">
        @if($carouselImages->isNotEmpty())
            <div class="carousel infinite-carousel flex items-center justify-center overflow-hidden">
                @foreach($carouselImages as $image)
                    <div class="carousel-slide {{ $loop->first ? 'full-slide' : 'half-slide' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="object-cover w-full h-full">
                    </div>
                @endforeach
            </div>
        @else
            <div class="theme-board h-full w-full flex items-center justify-center text-gray-300">
                <p>No images to display</p>
            </div>
        @endif
    </div>

    <!-- Banner Buttons -->
    <div class="absolute bottom-8 flex justify-center w-full space-x-4">
        <a href="{{ route('register') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-800">Get Started</a>
        <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-800">Login</a>
    </div>
</div>
