<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Get authenticated user's profile details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Build full image URL if image exists
        $imageUrl = null;
        if ($user->img) {
            $imageUrl = url($user->img);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile fetched successfully',
            'data' => [
                'id' => $user->id,
                'unique_id' => $user->unique_id,
                'f_name' => $user->f_name,
                'l_name' => $user->l_name,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'dob' => $user->dob,
                'age' => $user->age,
                'gender' => $user->gender,
                'location' => $user->location,
                'about' => $user->about,
                'status' => $user->status,
                'image_url' => $imageUrl,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ], 200);
    }

    /**
     * Get all unblocked users with basic profile information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnblockedUsers(Request $request)
    {
        $users = User::where('status', '!=', 'blocked')
            ->orWhereNull('status')
            ->select(['id', 'f_name', 'l_name', 'img'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->full_name,
                    'image' => $user->img ? url($user->img) : null
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Users retrieved successfully',
            'data' => $users
        ], 200);
    }

    /**
     * Get user details by ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserById(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Check if the user is blocked (except for the authenticated user viewing their own profile)
        $authenticatedUser = $request->user();
        if ($user->status === 'blocked' && $authenticatedUser->id != $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Build full image URL if image exists
        $imageUrl = null;
        if ($user->img) {
            $imageUrl = url($user->img);
        }

        return response()->json([
            'status' => true,
            'message' => 'User details retrieved successfully',
            'data' => [
                'id' => $user->id,
                'unique_id' => $user->unique_id,
                'f_name' => $user->f_name,
                'l_name' => $user->l_name,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'dob' => $user->dob,
                'age' => $user->age,
                'gender' => $user->gender,
                'location' => $user->location,
                'about' => $user->about,
                'status' => $user->status,
                'image_url' => $imageUrl,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ], 200);
    }
}
