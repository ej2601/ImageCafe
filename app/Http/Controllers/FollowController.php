<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $currentUser = auth()->user();

        // Prevent following oneself
        if ($currentUser->id === $user->id) {
            return response()->json(['message' => 'You cannot follow yourself.'], 400);
        }

        // Check if already following
        if (!$currentUser->following()->where('followed_id', $user->id)->exists()) {
            $currentUser->following()->create([
                'followed_id' => $user->id,
            ]);

            return response()->json(['message' => 'Followed successfully.'], 200);
        }

        return response()->json(['message' => 'Already following this user.'], 400);
    }

    public function unfollow(User $user)
    {
        $currentUser = auth()->user();

        // Check if the relationship exists before trying to delete
        if ($currentUser->following()->where('followed_id', $user->id)->exists()) {
            $currentUser->following()->where('followed_id', $user->id)->delete();

            return response()->json(['message' => 'Unfollowed successfully.'], 200);
        }

        return response()->json(['message' => 'Not following this user.'], 400);
    }
}
