<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the most liked images for the carousel (up to 12) (WIP)
        // $carouselImages = Image::withCount('likes')
        //     ->orderBy('likes_count', 'desc')
        //     ->take(12)
        //     ->get();

        // Fetch categories for the category navbar
        $categories = Category::all();

        // Step 1: Build the query with filters and sorting
        $query = Image::where('is_published', true)->filter($request->only(['search', 'category']))
            ->sortBy($request->input('sortOrder', 'latest'));

        // Step 2: Get the IDs of images that exist in storage
        $existingImageIds = $query->pluck('id')->filter(function ($id) {
            $image = Image::find($id);
            return $image && Storage::disk('public')->exists($image->image_path);
        });

        // Step 3: Paginate based on existing images
        $images = $query->whereIn('id', $existingImageIds)->with('user', 'likes')->withCount('likes')->paginate(10);

        // Attach categories and is_followed manually for each image
        foreach ($images as $image) {
            // Attach categories
            $image->categories = $image->categories(); // Use the custom categories() method
            $image->created_at = $image->created_at->diffForHumans();
            // Attach is_followed attribute to the user
            if (auth()->check()) {
                $image->user->is_followed = $image->user->followers->contains('follower_id', auth()->id());
            } else {
                $image->user->is_followed = false;
            }
        }

        // dd($images->items());
        // Check if it's an AJAX request to return only images
        if ($request->ajax()) {
            return response()->json([
                'images' => $images->items(),
                'next_page_url' => $images->nextPageUrl(),
                'lastPage' => $images->lastPage(),
                'sortOrder' => $request->input('sortOrder', 'latest'),
            ]);
        }

        return view('dashboard', compact('categories', 'images'));
    }


    public function search(Request $request)
    {
        $query = $request->input('q');
        $users = User::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
            ->limit(10) // Limit results for efficiency
            ->get(['id', 'name', 'username', 'profile_image']); // Fetch only required fields


        // Attach follow state only for logged-in users
        if (auth()->check()) {
            $currentUserId = auth()->id();
            $users->each(function ($user) use ($currentUserId) {
                $user->following = $user->followers()->where('follower_id', $currentUserId)->exists();
            });
        } else {
            $users->each(function ($user) {
                $user->following = false; // Guests cannot follow/unfollow
            });
        }

        return response()->json($users);
    }
}
