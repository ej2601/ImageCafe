<?php

use App\Http\Controllers\ImageGenerationController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageDisplayController;
use App\Http\Controllers\ImageController;

use App\Http\Controllers\ExploreController;
use App\Http\Controllers\FollowController;

Route::get('/', [ExploreController::class, 'index'])->name('explore');

// Route::get('/', function () {
//     // dd(env('API_ENDPOINT'));
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/api/user-id', function () {
    return response()->json(['id' => auth()->id()]);
})->middleware('auth');

Route::get('/publicProfile/{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::get('/search/users', [ExploreController::class, 'search'])->name('search.users');

Route::middleware('auth')->group(function () {


    Route::get('/my-creations', [ImageController::class, 'index'])->name('images.index');
    Route::post('/my-creations/delete', [ImageController::class, 'bulkDelete'])->name('images.bulk-delete');
    Route::get('/my-creations/search', [ImageController::class, 'search'])->name('images.search');

    Route::get('/image/{id}', [ImageDisplayController::class, 'show'])->name('image.show');

    Route::post('/image/{id}/publish', [ImageDisplayController::class, 'publish'])->name('images.publish.store');
    Route::post('/image/{id}/unpublish', [ImageDisplayController::class, 'unpublish'])->name('images.unpublish');

    Route::post('/image/{id}/like', [ImageDisplayController::class, 'like'])->name('images.like');

    Route::delete('/image/{id}', [ImageDisplayController::class, 'destroy'])->name('images.destroy');
    Route::get('/image/{id}/download', [ImageDisplayController::class, 'download'])->name('images.download');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route to display the image generation page
    Route::get('/image-generation', [ImageGenerationController::class, 'index'])->name('image.generation');
    Route::post('/image-generation/generate', [ImageGenerationController::class, 'generate'])->name('image.generate');


    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
});

require __DIR__ . '/auth.php';
