<div x-data="userSearch()" class="relative px-2">
    <!-- Search Input -->
    <input
        type="text"
        x-model="query"
        x-on:input.debounce.300ms="fetchUsers"
        placeholder="Search users..."
        class="bg-gray-100 text-purple-800 border border-purple-600 rounded-lg px-4 py-2 lg:w-80 focus:ring-2 focus:ring-purple-500 focus:outline-none transition" />

    <!-- Dropdown Results -->
    <div x-show="users.length > 0" class="absolute h-[50vh] overflow-y-auto z-10 w-full bg-white border rounded-lg shadow-lg">
        <template x-for="user in users" :key="user.id">
            <div  class="flex items-center justify-between p-3 hover:bg-gray-100">
                <!-- User Info -->
                <a :href="`/publicProfile/${user.username}`" class="flex items-center space-x-3">
        <img :src="user.profile_image" alt="Profile" class="w-8 h-8 rounded-full">
        <div>
            <p class="font-medium text-gray-700" x-text="user.name"></p>
            <p class="text-sm text-gray-500" x-text="'@' + user.username"></p>
        </div>
    </a>
                
                <!-- Follow/Unfollow Button -->

                <!-- Follow/Unfollow Button -->
                <form
                x-show="authId && authId !== user.id"
                    x-data="{ isFollowed: false }"
                    x-init="isFollowed = user.following"
                    method="POST"
                    @submit.prevent="async function handleFollow(e) {
        const url = isFollowed 
            ? `/unfollow/${user.id}` // Dynamically construct the unfollow URL
            : `/follow/${user.id}`; // Dynamically construct the follow URL
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
                        class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                        <span x-text="isFollowed ? 'Unfollow' : 'Follow'"></span>
                    </button>
                </form>
        
            </div>
        </template>
    </div>
</div>


<script>
    function userSearch() {
        return {
            query: '',
            authId: {{ auth()->id() ?? 'null' }},
            users: [],

            fetchUsers() {
                if (this.query.trim() === '') {
                    this.users = [];
                    return;
                }

                // Axios GET request for user search
                axios.get('/search/users', {
                        params: {
                            q: this.query
                        },
                    })
                    .then(response => {
                        this.users = response.data.map(user => ({
                            ...user,
                             // Add initial follow state (dynamic later)
                        }));
                        console.log(this.users);
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                    });
            },

        };
    }
</script>