<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user registration request
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required|string|unique:users,username|max:255',
    //         'email' => 'required|string|email|unique:users,email|max:255',
    //         'password' => 'required|string|min:8|confirmed',
    //         'phone' => 'required|string|max:20',
    //         'full_name' => 'required|string|max:255',
    //         'role' => 'sometimes|string|in:admin,mentor,mentee,company,secretary,kepalaSekolah',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $user = User::create([
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'phone' => $request->phone,
    //         'full_name' => $request->full_name,
    //         'role' => $request->role ?? 'mentee', // Default to mentee if not specified
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'access_token' => $token,
    //         'token_type' => 'Bearer'
    //     ], 201);
    // }

    /**
     * Handle user login request
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $request->username,
            'password' => $request->password
        ];
        
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Username/Email atau password salah',
            ], 401);
        }
        
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'redirect' => '/dashboard',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role
        ]);
    }
    /**
     * Handle user logout request
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
 // Controller
 public function logout(Request $request)
{
    try {
        // Hapus token Sanctum
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }
        
        // Logout dari session web
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Logout gagal: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Get authenticated user details
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ]);
    }
    
    /**
     * Change user password
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password does not match'
            ], 401);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password successfully changed'
        ]);
    }
}