<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{

    public function index(Request $request)
    {
        // Step 1: Build the query with filters and sorting
        $query = Image::where('user_id', auth()->id()) // Filter images by the current user
            ->filter($request->only(['search']))
            ->sortBy($request->input('sortOrder', 'latest'));

        // Step 2: Get the IDs of images that exist in storage
        $existingImageIds = $query->pluck('id')->filter(function ($id) {
            $image = Image::find($id);
            return $image && Storage::disk('public')->exists($image->image_path);
        });

        // Step 3: Paginate based on existing images
        $images = $query->whereIn('id', $existingImageIds)->with('user', 'likes')->withCount('likes')->paginate(10);

        // Check if it's an AJAX request to return only images
        if ($request->ajax()) {

            return response()->json([
                'images' => $images->items(),
                'next_page_url' => $images->nextPageUrl(),
                'lastPage' => $images->lastPage(),
                'sortOrder' => $request->input('sortOrder', 'latest'),
            ]);
        }

        // Step 4: Return the view with the paginated images
        return view('images.my-creations', compact('images'));
    }



    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:images,id',
        ]);

        Image::whereIn('id', $validated['selected_images'])
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->route('images.index')->with('status', 'Images deleted successfully.');
    }
}
