<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Image;

class ImageGenerationController extends Controller
{
    private $apiKey;
    private $apiEndpoint;

    public function __construct()
    {
        $this->apiKey = env('API_KEY');
        $this->apiEndpoint = env('API_ENDPOINT');
    }

    // Show the image generation page
    public function index()
    {
        // dd(env('API_ENDPOINT'));
        return view('images/image_generation');
    }

    // Handle image generation request
    public function generate(Request $request)
    {


        // Validate the input fields
        $validated = $request->validate([
            'width' => [
                'required',
                'integer',
                'min:256',
                'max:1024',
                function ($attribute, $value, $fail) {
                    if ($value % 8 !== 0) {
                        $fail('The ' . $attribute . ' must be divisible by 8.');
                    }
                },
            ],
            'height' => [
                'required',
                'integer',
                'min:256',
                'max:1024',
                function ($attribute, $value, $fail) {
                    if ($value % 8 !== 0) {
                        $fail('The ' . $attribute . ' must be divisible by 8.');
                    }
                },
            ],
            'prompt' => 'required|string|max:500|min:4',
            'seed_option' => 'required|string|in:random,custom',
            'custom_seed' => 'nullable|required_if:seed_option,custom|integer',
        ]);

        // Handle Seed (custom or random)
        $seed = $validated['seed_option'] === 'custom' ? $validated['custom_seed'] : rand();

        // Prepare data for the API request
        $apiData = [
            "inputs" => $validated['prompt'],
            "parameters" => [
                "num_inference_steps" => 4,
                "width" => intval($validated['width']),
                "height" => intval($validated['height']),
            ],
            "seed" => $seed,
        ];


        // Return the json-encoded data for debugging
        // return response()->json(json_encode($apiData));

        try {
            // Call the external API (replace with your API endpoint and key)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('API_KEY'),
                // 'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post(env('API_ENDPOINT'), $apiData);

            // Check for a successful response
            if ($response->successful()) {
                // Convert the response to a blob and return as an image
                $imageBlob = $response->body(); // Get the image blob content

                // Determine user directory based on username
                $username = auth()->user()->name;
                $directory = "created_images/{$username}";

                // Create the directory if it doesn't exist
                // if (!Storage::exists($directory)) {
                //     Storage::makeDirectory($directory);
                // }

                // Define the image file name and path
                $filename = 'generated_image_' . time() . '.jpg'; // Adjust extension as needed
                $imagePath = "{$directory}/{$filename}";

                // Store the image in the user folder
                Storage::disk('public')->put($imagePath, $imageBlob);

                // Save image details in the database
                $image = Image::create([
                    'user_id' => auth()->id(),
                    'title' => 'Generated Image ' . time(),
                    'prompt' => $validated['prompt'],
                    'image_path' => $imagePath,
                    'width' => $validated['width'],
                    'height' => $validated['height'],
                    'aspect_ratio' => round($validated['width'] / $validated['height'], 2),
                    'seed' => $seed,
                    'category_ids' => null, // Set based on your application logic
                    'is_published' => false,
                    'can_download' => false,
                    'hide_prompt' => false,
                ]);

                // Return the generated image path as a response
                return response()->json([
                    'message' => 'Image generated and saved successfully.',
                    'image_path' => Storage::url($imagePath),
                    'image_id' => $image->id,
                ], 200);

                // Return the image as a binary response with appropriate headers
                // return response($imageBlob, 200)
                //     ->header('Content-Type', 'image/jpeg'); // or 'image/png', depending on the API response
            } else {
                // Handle error
                Log::error('API Error: ' . $response->body());
                return response()->json(['error' => 'Image generation failed. Please try again.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('API Request Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during image generation.'], 500);
        }
    }

    // Handle image publishing, opening, or deletion

}
