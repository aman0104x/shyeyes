<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Like a user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeUser(Request $request, $userId)
    {
        $user = Auth::user();

        // Check if user is trying to like themselves
        if ($user->id == $userId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot like yourself'
            ], 400);
        }

        // Check if the user to be liked exists
        $likedUser = User::find($userId);
        if (!$likedUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Check if already liked
        $existingLike = UserLike::where('liker_id', $user->id)
                                ->where('liked_id', $userId)
                                ->first();

        if ($existingLike) {
            return response()->json([
                'success' => false,
                'message' => 'You have already liked this user'
            ], 400);
        }

        // Create the like
        $like = UserLike::create([
            'liker_id' => $user->id,
            'liked_id' => $userId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User liked successfully',
            'data' => $like
        ], 201);
    }

    /**
     * Get users who liked a specific user
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLikedBy($userId)
    {
        // Check if the user exists
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Get users who liked this user
        $likers = User::whereHas('likesGiven', function($query) use ($userId) {
            $query->where('liked_id', $userId);
        })->with(['likesGiven' => function($query) use ($userId) {
            $query->where('liked_id', $userId);
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $likers
        ]);
    }

    /**
     * Get users whom a specific user has liked
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLikes($userId)
    {
        // Check if the user exists
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Get users whom this user has liked
        $likedUsers = User::whereHas('likesReceived', function($query) use ($userId) {
            $query->where('liker_id', $userId);
        })->with(['likesReceived' => function($query) use ($userId) {
            $query->where('liker_id', $userId);
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $likedUsers
        ]);
    }

    /**
     * Unlike a user
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlikeUser($userId)
    {
        $user = Auth::user();

        $like = UserLike::where('liker_id', $user->id)
                        ->where('liked_id', $userId)
                        ->first();

        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => 'Like not found'
            ], 404);
        }

        $like->delete();

        return response()->json([
            'success' => true,
            'message' => 'User unliked successfully'
        ]);
    }
}
