<?php

namespace App\Http\Controllers\Controller\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // Show Admin Login Form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Admin Login - Fetch credentials from admin table
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:6'
        ], [
            'email.exists' => 'This email is not registered as an admin.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Attempt login using guard
        if (!Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $admin = Auth::guard('admin')->user();

        // Check if admin is active

        return response()->json([
            'status' => "Success",
            'message' => 'Login successful',
            'admin' => [
                'name' => $admin->name
            ]
        ]);
    }


    // Admin Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // Get Admin Profile
    public function profile(Request $request)
    {
        $admin = $request->user();

        return response()->json([
            'status' => true,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'profile_image' => $admin->profile_image,
                'is_active' => $admin->is_active,
                'created_at' => $admin->created_at
            ]
        ]);
    }

    // Update Admin Profile
    public function updateProfile(Request $request)
    {
        $admin = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $admin->name = $request->name;
        $admin->phone = $request->phone;

        if ($request->hasFile('profile_image')) {
            $filename = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('uploads/admins'), $filename);
            $admin->profile_image = 'uploads/admins/' . $filename;
        }

        $admin->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'profile_image' => $admin->profile_image
            ]
        ]);
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = $request->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
