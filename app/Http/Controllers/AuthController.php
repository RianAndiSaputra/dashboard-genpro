<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MenteeProfile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'         => 'required|string|unique:users,username|max:255',
            'email'            => 'required|string|email|unique:users,email|max:255',
            'full_name'        => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'tanggal_lahir'    => 'required|string|max:255',
            'role'             => 'sometimes|string|in:mentee,mentor,admin,company,secretary,kepalaSekolah',
            
            // MenteeProfile fields
            'nama_bisnis'      => 'required|string|max:255',
            'address'          => 'required|string|max:255',
            'profile_picture'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang_usaha'     => 'required|string|max:255',
            'badan_hukum'      => 'required|string|max:255',
            'tahun_berdiri'    => 'required|string',
            'jumlah_karyawan'  => 'required|integer',
            'jumlah_omset'     => 'required|integer',
            'jabatan'          => 'required|string|max:255',
            'komitmen'         => 'required|in:iya,tidak',
            'gambar_laporan'   => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:102400',
        ]);
    
            // Selalu kembalikan JSON untuk API
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }
    
            DB::beginTransaction();
            try {
                // Create User with tanggal_lahir as password
                $user = User::create([
                    'username'   => $request->username,
                    'email'      => $request->email,
                    'tanggal_lahir'  => $request->tanggal_lahir,
                    'password'   => Hash::make($request->tanggal_lahir),
                    'phone'      => $request->phone,
                    'full_name'  => $request->full_name,
                    'role'       => $request->role ?? 'mentee',
                ]);
                
                // Store uploaded files
                $profilePicPath = $request->file('profile_picture')->store('mentee_profiles', 'public');
                $laporanPath    = $request->file('gambar_laporan')->store('mentee_reports', 'public');
                
                // Create MenteeProfile linked to user
                MenteeProfile::create([
                    'user_id'         => $user->user_id,
                    'nama_bisnis'     => $request->nama_bisnis,
                    'address'         => $request->address,
                    'profile_picture' => $profilePicPath,
                    'bidang_usaha'    => $request->bidang_usaha,
                    'badan_hukum'     => $request->badan_hukum,
                    'tahun_berdiri'   => $request->tahun_berdiri,
                    'jumlah_karyawan' => $request->jumlah_karyawan,
                    'jumlah_omset'    => $request->jumlah_omset,
                    'jabatan'         => $request->jabatan,
                    'komitmen'        => $request->komitmen,
                    'gambar_laporan'  => $laporanPath,
                ]);
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi mentee berhasil!',
                    'redirect' => route('mentee.index')
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                // Hapus file yang sudah diupload jika ada error
                if (isset($profilePicPath)) {
                    Storage::disk('public')->delete($profilePicPath);
                }
                if (isset($laporanPath)) {
                    Storage::disk('public')->delete($laporanPath);
                }
    
        DB::beginTransaction();
        try {
            // Create User with tanggal_lahir as password
            $user = User::create([
                'username'   => $request->username,
                'email'      => $request->email,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'password'   => Hash::make($request->tanggal_lahir),
                'phone'      => $request->phone,
                'full_name'  => $request->full_name,
                'role'       => $request->role ?? 'mentee',
            ]);
            
            // Store uploaded files
            $profilePicPath = $request->file('profile_picture')->store('mentee_profiles', 'public');
            $laporanPath    = $request->file('gambar_laporan')->store('mentee_reports', 'public');
            
            // Create MenteeProfile linked to user
            MenteeProfile::create([
                'user_id'         => $user->user_id,
                'nama_bisnis'     => $request->nama_bisnis,
                'address'         => $request->address,
                'profile_picture' => $profilePicPath,
                'bidang_usaha'    => $request->bidang_usaha,
                'badan_hukum'     => $request->badan_hukum,
                'tahun_berdiri'   => $request->tahun_berdiri,
                'jumlah_karyawan' => $request->jumlah_karyawan,
                'jumlah_omset'    => $request->jumlah_omset,
                'jabatan'         => $request->jabatan,
                'komitmen'        => $request->komitmen,
                'gambar_laporan'  => $laporanPath,
            ]);
            
            DB::commit();
            
            return redirect()->route('mentee.index')->with('success', 'Registrasi mentee berhasil!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan server: '.$e->getMessage())->withInput();
        }
    }
}

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