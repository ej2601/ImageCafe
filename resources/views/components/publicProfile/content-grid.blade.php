@props(['images', 'type', 'items'])

@if($type === 'images')
<!-- Image Grid -->
<x-image-grid
    :images="$images"
    :showTitle="false"
    :showCheckbox="false"
    :showImageViewModal="true"
    customClass="custom-page-without-checkbox" />

<script>
    const imageData = @json($images -> items());
    const nextPageUrl = @json($images -> nextPageUrl());
    const sortOrder = "{{ request('sortOrder', 'latest') }}";
    const bulkDeleteRoute = "{{ route('images.bulk-delete') }}";
</script>

@endif

@if($type === 'followers' || $type === 'following')
<div class="grid grid-cols-1 gap-4">
    @foreach($items as $item)
    @php
        $user = $type === 'followers' ? $item->follower : $item->followed;
    @endphp
    <div class="flex items-center justify-between p-4 bg-white border rounded-lg shadow-sm">
        <!-- Left Section: Profile Image and User Info -->
        <div class="flex items-center space-x-3">
            <img src="{{ $user->profile_image }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
            <div>
                <a href="{{ route('profile.show', $user->username) }}" class="text-gray-700 hover:text-purple-600 font-bold">
                    {{ $user->name }}
                </a>
                <p class="text-sm text-gray-500">{{ '@' . $user->username }}</p>
            </div>
        </div>
        <!-- Right Section: Follow/Unfollow Button -->
        <div>
            @if(auth()->check() && auth()->id() !== $user->id)
            <!-- Follow/Unfollow Button -->
          
            <form
                x-data="{ isFollowed: {{$user -> is_followed ? 'true' : 'false' }} }"
                :action="isFollowed ? '{{ route('unfollow', ['user' => $user->id]) }}' : '{{ route('follow', ['user' => $user->id]) }}'"
                method="POST"
                @submit.prevent="async function handleFollow(e) {
                const url = isFollowed 
                    ? '{{ route('unfollow', ['user' => $user->id]) }}' 
                    : '{{ route('follow', ['user' => $user->id]) }}';
                const response = await axios.post(url, { _token: '{{ csrf_token() }}' });
                if (response.status === 200) {
                    isFollowed = !isFollowed;
                }
            }(event)">
                @csrf
                <button
                    type="submit"
                    :class="isFollowed 
                    ? 'bg-purple-200 text-purple-800 border-2 border-purple-500' 
                    : 'bg-purple-600 text-white border border-transparent'"
                    class="inline-flex items-center px-4 py-3 dark:bg-purple-500 hover:text-white rounded-md font-semibold text-xs dark:text-gray-200 border-double uppercase tracking-widest hover:bg-purple-500 dark:hover:bg-purple-400 focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <span x-text="isFollowed ? 'Unfollow -' : 'Follow +'"></span>
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination Links -->

@endif