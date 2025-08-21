<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = Auth::user();

        // 🚫 Check if user is blocked
        if ($user->status === 'blocked') {
            Auth::logout();
            return response()->json([
                'status' => false,
                'message' => 'Your account has been blocked. Please contact support.'
            ], 403);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            // 'user' => $user
        ]);
    }


    // STEP 1: Basic details
    public function step1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string|max:50',
            'l_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'unique_id' => uniqid('USR'),
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Step 1 completed successfully',
            'user_id' => $user->id,
            'token' => $token
        ]);
    }

    // STEP 2: Additional details


    public function step2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dob' => 'nullable|date_format:d F Y|date',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:male,female,other',
            'location' => 'nullable|string|max:255',
            'about' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        // Get user from token
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        // Handle Image Upload
        if ($request->hasFile('img')) {
            $filename = time() . '.' . $request->img->extension();
            $request->img->move(public_path('uploads/users'), $filename);
            $user->img = 'uploads/users/' . $filename;
        }

        // Parse and format the date
        $formattedDob = null;
        if ($request->dob) {
            try {
                $formattedDob = \Carbon\Carbon::createFromFormat('d F Y', $request->dob)->format('Y-m-d');
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid date format. Please use format like "11 July 1987"'
                ], 422);
            }
        }

        $user->dob = $formattedDob;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->location = $request->location;
        $user->about = $request->about;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Registration completed successfully',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        // Delete current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
