<div class="profile-header flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8 dark:bg-gray-900 rounded-lg p-6">
    <!-- Profile Image -->
    <div class="flex-shrink-0">
        <img src="{{ $user->profile_image }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full shadow-lg">
    </div>

    <!-- Profile Details -->
    <div class="flex-grow text-center md:text-left">
        <!-- User Name -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>

        <!-- Actions (Follow/Unfollow & Share) -->
        <div class="flex justify-center md:justify-start space-x-4 mt-4">

            @auth
            @if(auth()->id() !== $user->id)
            <!-- Follow/Unfollow Button -->
            <form
                x-data="{ isFollowed: {{ $user -> is_followed ? 'true' : 'false' }} }"
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
            @endauth


            <!-- Share Button -->
            <button
                @click="shareProfile('{{ route('profile.show', $user->id) }}')"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 shadow-sm">
                Share
            </button>
        </div>

        <!-- Published Images Count -->
        <p class="mt-4 text-gray-500 dark:text-gray-400">{{ $user->images->count() }} images published</p>
    </div>
</div>