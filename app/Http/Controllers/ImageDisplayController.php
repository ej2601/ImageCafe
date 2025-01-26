<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\Like;

use Illuminate\Http\Request;


class ImageDisplayController extends Controller
{
    public function show($id)
    {
        // Fetch image data from the database
        $image = Image::findOrFail($id);

        // Check if the image belongs to the currently authenticated user
        if ($image->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to view this image.');
        }

        $categories = Category::all();

        return view('images.display', compact('image', 'categories'));
    }

    // // Show Publish Modal
    // public function showPublishModal(Image $image)
    // {
    //     $categories = Category::all();
    //     return view('images.publish', compact('image', 'categories'));
    // }

    // Handle Publish Image Request
    public function publish(Request $request, $id)
    {
        // dd($request);
        $image = Image::findOrFail($id);


        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',

        ]);

        $image->update([
            'title' => $validatedData['title'],
            'category_ids' => $validatedData['category_ids'] ?? [],
            'is_published' => true,
            'can_download' => (bool) $request['can_download'] ?? false,
            'hide_prompt' => (bool) $request['hide_prompt'] ?? false,
        ]);

        return redirect()->back()->with('success', 'Image published successfully!');
    }

    public function unpublish($id)
    {
        $image = Image::findOrFail($id);
        $image->is_published = false;
        $image->save();

        return redirect()->back()->with('success', 'Image unpublished successfully.');
    }

    public function like($id)
    {

        // Handle the like functionality here
        $image = Image::findOrFail($id);

        // Check if the user has already liked the image
        $existingLike = Like::where('user_id', auth()->id())->where('image_id', $id)->first();

        if ($existingLike) {
            // If already liked, we could allow "unlike" functionality
            $existingLike->delete();
            return response()->json(['likes' => $image->likes()->count(), 'liked' => false]);
        } else {
            // Add a new like
            Like::create(['user_id' => auth()->id(), 'image_id' => $id]);
            return response()->json(['likes' => $image->likes()->count(), 'liked' => true]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'Images deleted successfully.',

            ]);
        }

        return redirect()->route('images.index')->with('success', 'Image deleted successfully.');
    }

    public function download($id)
    {
        $image = Image::findOrFail($id);
        $path = storage_path('app/public/' . $image->image_path);

        return response()->download($path);
    }
}
