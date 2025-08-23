<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserImage;

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

        // Profile Image URL
        $imageUrl = null;
        if ($user->img && file_exists(public_path($user->img))) {
            $imageUrl = asset($user->img);
        }

        // Cover Photo URL
        $coverPhotoUrl = null;
        if ($user->cover_photo && file_exists(public_path($user->cover_photo))) {
            $coverPhotoUrl = asset($user->cover_photo);
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
                'cover_photo_url' => $coverPhotoUrl, // 👈 Added this
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
                $imageUrl = null;
                if ($user->img && file_exists(public_path($user->img))) {
                    $imageUrl = asset($user->img);
                }
                return [
                    'id' => $user->id,
                    'name' => $user->full_name,
                    'image' => $imageUrl
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

        // Build full image URL with proper file existence check
        $imageUrl = null;
        if ($user->img && file_exists(public_path($user->img))) {
            $imageUrl = asset($user->img);
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

    /**
     * Get opposite gender users based on authenticated user's gender
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOppositeGenderUsers(Request $request)
    {
        $authenticatedUser = $request->user();

        if (!$authenticatedUser) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Determine opposite gender
        $oppositeGender = null;
        if ($authenticatedUser->gender === 'male') {
            $oppositeGender = 'female';
        } elseif ($authenticatedUser->gender === 'female') {
            $oppositeGender = 'male';
        } else {
            // Handle other gender cases
            return response()->json([
                'status' => true,
                'message' => 'No opposite gender users found',
                'data' => []
            ], 200);
        }

        // Get opposite gender users who are not blocked
        $oppositeGenderUsers = User::where('gender', $oppositeGender)
            ->where('status', '!=', 'blocked')
            ->orWhereNull('status')
            ->select(['id', 'f_name', 'l_name', 'img', 'age', 'unique_id'])
            ->get()
            ->map(function ($user) {
                $imageUrl = null;
                if ($user->img && file_exists(public_path($user->img))) {
                    $imageUrl = asset($user->img);
                }
                return [
                    'userid' => $user->id,
                    'name' => $user->full_name,
                    'age' => $user->age,
                    'img' => $imageUrl
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Best matches retrieved successfully',
            'data' => $oppositeGenderUsers
        ], 200);
    }

    /**
     * Update authenticated user's profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'f_name' => 'sometimes|string|max:255',
            'l_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'dob' => 'sometimes|date',
            'gender' => 'sometimes|string|in:male,female,other',
            'location' => 'sometimes|string|max:255',
            'about' => 'sometimes|string|max:1000',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image upload if provided
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_profile.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/users/' . $imageName;
            $image->move(public_path('uploads/users'), $imageName);
            $validatedData['img'] = $imagePath;
        }

        // Handle cover photo upload if provided
        if ($request->hasFile('cover_photo')) {
            $coverPhoto = $request->file('cover_photo');
            $coverPhotoName = time() . '_cover.' . $coverPhoto->getClientOriginalExtension();
            $coverPhotoPath = 'uploads/users/' . $coverPhotoName;
            $coverPhoto->move(public_path('uploads/users'), $coverPhotoName);
            $validatedData['cover_photo'] = $coverPhotoPath;
        }

        // Update user profile
        $user->update($validatedData);

        // Build full image URL with proper file existence check
        $imageUrl = null;
        if ($user->img && file_exists(public_path($user->img))) {
            $imageUrl = asset($user->img);
        }

        // Build full cover photo URL with proper file existence check
        $coverPhotoUrl = null;
        if ($user->cover_photo && file_exists(public_path($user->cover_photo))) {
            $coverPhotoUrl = asset($user->cover_photo);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
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
                'cover_photo_url' => $coverPhotoUrl, // 👈 Added here
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ], 200);
    }

    /**
     * Upload multiple images for user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImages(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate the request data
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'uploads/users/' . $imageName;
                $image->move(public_path('uploads/users'), $imageName);

                // Save image record to database
                $userImage = UserImage::create([
                    'user_id' => $user->id,
                    'image_path' => $imagePath
                ]);

                $uploadedImages[] = [
                    'id' => $userImage->id,
                    'image_url' => asset($imagePath)
                ];
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Images uploaded successfully',
            'data' => $uploadedImages
        ], 200);
    }

    /**
     * Get all images for authenticated user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserImages(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $images = $user->images->map(function ($image) {
            $imageUrl = null;
            if ($image->image_path && file_exists(public_path($image->image_path))) {
                $imageUrl = asset($image->image_path);
            }
            return [
                'id' => $image->id,
                'image_url' => $imageUrl,
                'created_at' => $image->created_at
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'User images retrieved successfully',
            'data' => $images
        ], 200);
    }

    /**
     * Delete a user image
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $imageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request, $imageId)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $image = UserImage::where('id', $imageId)
            ->where('user_id', $user->id)
            ->first();

        if (!$image) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found or unauthorized'
            ], 404);
        }

        // Delete the physical file
        if ($image->image_path && file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Delete the database record
        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ], 200);
    }
}
