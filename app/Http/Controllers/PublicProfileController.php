<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show(User $user, Request $request)
    {
        $tab = $request->query('tab', 'most_recent'); // Default tab is 'most_recent'

        $images = collect(); // Default empty collection for images
        $followers = collect(); // Default empty collection for followers
        $following = collect(); // Default empty collection for following

        // Fetch and filter based on the selected tab
        switch ($tab) {
            case 'most_liked':
                $images = $user->images()->where('is_published', true)
                    // ->filter($request->only(['search', 'category']))
                    ->withCount('likes')
                    ->orderBy('likes_count', 'desc');
                break;

            case 'images_liked':
                $images = $user->likedImages()->where('is_published', true)
                    // ->filter($request->only(['search', 'category']))
                    ->with(['user', 'likes'])
                    ->withCount('likes')
                    ->paginate(10);
                break;

            case 'followers':
                $followers = $user->followers()
                    ->with('follower')
                    ->get()
                    ->map(function ($follow) {
                        $follow->follower->is_followed = auth()->check() && auth()->user()->following->contains('followed_id', $follow->follower->id);
                        return $follow;
                    })
                    ;
                break;

            case 'following':
                $following = $user->following()
                    ->with('followed')
                    ->get()
                    ->map(function ($follow) {
                        $follow->followed->is_followed = auth()->check() && auth()->user()->following->contains('followed_id', $follow->followed->id);
                        return $follow;
                    })
                    ;
                break;

            default: // 'most_recent'
                $images = $user->images()->where('is_published', true)
                    // ->filter($request->only(['search', 'category']))
                    ->sortBy($request->input('sortOrder', 'latest'));
        }

        // Check for images that exist in storage and process categories/is_followed
        if ($tab !== 'followers' && $tab !== 'following' && $tab !== 'images_liked') {

            $existingImageIds = $images->pluck('id')->filter(function ($id) {
                $image = Image::find($id);
                return $image && Storage::disk('public')->exists($image->image_path);
            });

            $images = $images->with('user', 'likes')->withCount('likes')->whereIn('id', $existingImageIds)->paginate(10);

            // Attach categories and is_followed manually for each image
            foreach ($images as $image) {
                // Attach categories
                $image->categories = $image->categories(); // Use the custom categories() method

                // Attach is_followed attribute to the user
                if (auth()->check()) {
                    $image->user->is_followed = $image->user->followers->contains('follower_id', auth()->id());
                } else {
                    $image->user->is_followed = false;
                }
            }
        }


        // Attach is_followed to the profile user
        $user->is_followed = auth()->check() && auth()->user()->following->contains('followed_id', $user->id);


        // Handle AJAX requests for infinite scrolling
        if ($request->ajax()) {
            return response()->json([
                'images' => $images->items(),
                'next_page_url' => $images->nextPageUrl(),
                'lastPage' => $images->lastPage(),
                'sortOrder' => $request->input('sortOrder', 'latest'),
            ]);
        }

        // dd($images);
        // Pass all data to the view
        return view('profile.show', compact('user', 'tab', 'images', 'followers', 'following'));
    }
}
