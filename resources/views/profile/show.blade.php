<x-app-layout mainBodyClass="md:h-screen">
    <x-slot name="header">
        <x-publicProfile.header :user="$user" :isFollowing="true" />
        <x-publicProfile.tabs-navbar :currentTab="$tab" :user="$user" />
    </x-slot>

    <div class="pb-8 px-4 flex-column bg-white w-screen h-full overflow-y-scroll" x-data="ImageGrid.imageManager()" x-ref="imageGrid" data-images="@json($images)">


        @if($tab === 'most_recent' || $tab === 'most_liked' || $tab === 'images_liked')
        <x-publicProfile.content-grid :images="$images" type="images" />
        @elseif($tab === 'followers')
        <x-publicProfile.content-grid :items="$followers" type="followers" />
        @elseif($tab === 'following')
        <x-publicProfile.content-grid :items="$following" type="following" />
        @endif
    </div>


</x-app-layout>