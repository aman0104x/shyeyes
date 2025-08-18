<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        ]);
    }
}
