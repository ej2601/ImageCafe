@props(['user','currentTab'])

<div class="tabs-navbar py-4 rounded-lg mb-4 overflow-x-auto bg-gray-100 dark:bg-gray-800 flex space-x-4 px-4 sticky top-0 z-30">
    <a href="{{ route('profile.show', ['user' => $user->username, 'tab' => 'most_recent']) }}" 
       class="{{ $currentTab === 'most_recent' ? 'text-purple-600' : 'text-gray-700 hover:text-purple-600' }}">
        Most Recent
    </a>
    <a href="{{ route('profile.show', ['user' => $user->username, 'tab' => 'most_liked']) }}" 
       class="{{ $currentTab === 'most_liked' ? 'text-purple-600' : 'text-gray-700 hover:text-purple-600' }}">
        Most Liked
    </a>
    <a href="{{ route('profile.show', ['user' => $user->username, 'tab' => 'images_liked']) }}" 
       class="{{ $currentTab === 'images_liked' ? 'text-purple-600' : 'text-gray-700 hover:text-purple-600' }}">
        Liked Images
    </a>
    <a href="{{ route('profile.show', ['user' => $user->username, 'tab' => 'followers']) }}" 
       class="{{ $currentTab === 'followers' ? 'text-purple-600' : 'text-gray-700 hover:text-purple-600' }}">
        Followers
    </a>
    <a href="{{ route('profile.show', ['user' => $user->username, 'tab' => 'following']) }}" 
       class="{{ $currentTab === 'following' ? 'text-purple-600' : 'text-gray-700 hover:text-purple-600' }}">
        Following
    </a>
</div>
