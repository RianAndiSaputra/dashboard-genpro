<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\MenteeProfile;
use App\Models\MutabaahReport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class MenteeProfileController extends Controller
{

   
    public function indexdashboard()
    {
        $menteeCount = MenteeProfile::count();
        $newMentees = MenteeProfile::whereDate('created_at', today())->count();
        
        // Untuk top business
        $topBusiness = MenteeProfile::select('bidang_usaha', DB::raw('count(*) as total'))
                           ->groupBy('bidang_usaha')
                           ->orderByDesc('total')
                           ->first();
        
        // Ambil data kelas
        $activeClasses = Kelas::where('status', 'active')
                            ->orderBy('tanggal_mulai', 'asc')
                            ->take(5)
                            ->get();
        
        $classCount = Kelas::count();
        $activeClassCount = Kelas::where('status', 'active')->count();
        
        // Hitung total mutabaah yang sudah diisi
        $mutabaahCount = MutabaahReport::count();
        $uniqueMenteesWithMutabaah = MutabaahReport::distinct('mentee_id')->count('mentee_id');
        
        // Hitung total perusahaan
        $companyCount = Company::count();
        
        return view('dashboard.dashboard', [
            'menteeCount' => $menteeCount,
            'newMentees' => $newMentees,
            'topBusiness' => $topBusiness,
            'activeClasses' => $activeClasses,
            'classCount' => $classCount,
            'activeClassCount' => $activeClassCount,
            'mutabaahCount' => $mutabaahCount,
            'uniqueMenteesWithMutabaah' => $uniqueMenteesWithMutabaah,
            'companyCount' => $companyCount
        ]);
    }
    /**
     * Display the mentee profile
     */
    public function profile()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();
        
        // Fetch only the mentee profile for the logged-in user
        $mentee = MenteeProfile::with('user')
                    ->where('user_id', $userId)
                    ->firstOrFail();
        
        return view('mente.profile-mente', compact('mentee'));
    }
    
    public function updateProfile(Request $request, $id)
    {
        // Ensure the user can only update their own profile
        $profile = MenteeProfile::where('user_id', auth()->id())
                    ->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'sometimes|string|max:255',
            'tanggal_lahir' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|string|email|max:255',
            'nama_bisnis' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang_usaha' => 'sometimes|string|max:255',
            'badan_hukum' => 'sometimes|string|max:255',
            'tahun_berdiri' => 'sometimes|string',
            'jumlah_karyawan' => 'sometimes|integer',
            'jabatan' => 'sometimes|string|max:255',
            'gambar_laporan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        DB::beginTransaction();
        try {
            // Handle profile picture replacement
            if ($request->hasFile('profile_picture')) {
                if ($profile->profile_picture) {
                    Storage::disk('public')->delete($profile->profile_picture);
                }
                $profile->profile_picture = $request->file('profile_picture')->store('mentee_profiles', 'public');
            }
            
            // Handle report image replacement
            if ($request->hasFile('gambar_laporan')) {
                if ($profile->gambar_laporan) {
                    Storage::disk('public')->delete($profile->gambar_laporan);
                }
                $profile->gambar_laporan = $request->file('gambar_laporan')->store('mentee_reports', 'public');
            }
            
            // Update mentee profile fields
            $profile->fill($request->only([
                'nama_bisnis', 'address', 'bidang_usaha', 'badan_hukum',
                'tahun_berdiri', 'jumlah_karyawan', 'jabatan'
            ]));
            $profile->save();
            
            // Update user fields
            $user = $profile->user;
            $user->fill($request->only([
                'full_name', 'tanggal_lahir', 'phone', 'email'
            ]));
            
            if ($request->filled('tanggal_lahir')) {
                $user->tanggal_lahir = $request->tanggal_lahir;
            }
            
            $user->save();
            
            DB::commit();
            
            return response()->json(['success' => 'Profile updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error updating profile: ' . $e->getMessage()], 500);
        }
    }
    
    public function indexView()
    {
        $mentees = MenteeProfile::with('user')->get();
        return view('mentees.index', compact('mentees'));
    }

    public function showFormulir()
    {
        $mentees = MenteeProfile::with('user')->get();
        return view('mente.formulir', compact('mentees'));
    }

    /**
     * List all mentee profiles with relations (API response).
     */
    public function index()
    {
        $profiles = MenteeProfile::with('user', 'company', 'kelas')->get();
        return response()->json($profiles, 200);
    }
    
    /**
     * Show a specific profile.
     */
    public function show($id)
    {
        try {
            $profile = MenteeProfile::with('user', 'company', 'kelas')->findOrFail($id);
            return response()->json($profile, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Profile not found'], 404);
        }
    }
    
    /**
     * Update profile details and file uploads.
     */
    public function update(Request $request, $id)
    {
        $profile = MenteeProfile::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'sometimes|string|max:255',
            'tanggal_lahir' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|string|email|max:255',
            'nama_bisnis' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang_usaha' => 'sometimes|string|max:255',
            'badan_hukum' => 'sometimes|string|max:255',
            'tahun_berdiri' => 'sometimes|string',
            'jumlah_karyawan' => 'sometimes|integer',
            'jabatan' => 'sometimes|string|max:255',
            'gambar_laporan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        DB::beginTransaction();
        try {
            // Handle profile picture replacement
            if ($request->hasFile('profile_picture')) {
                if ($profile->profile_picture) {
                    Storage::disk('public')->delete($profile->profile_picture);
                }
                $profile->profile_picture = $request->file('profile_picture')->store('mentee_profiles', 'public');
            }
            
            // Handle report image replacement
            if ($request->hasFile('gambar_laporan')) {
                if ($profile->gambar_laporan) {
                    Storage::disk('public')->delete($profile->gambar_laporan);
                }
                $profile->gambar_laporan = $request->file('gambar_laporan')->store('mentee_reports', 'public');
            }
            
            // Update mentee profile fields
            $profile->fill($request->only([
                'nama_bisnis', 'address', 'bidang_usaha', 'badan_hukum',
                'tahun_berdiri', 'jumlah_karyawan', 'jabatan'
            ]));
            $profile->save();
            
            // Update user fields
            $user = $profile->user;
            $user->fill($request->only([
                'full_name', 'tanggal_lahir', 'phone', 'email'
            ]));
            
            if ($request->filled('tanggal_lahir')) {
                $user->tanggal_lahir = $request->tanggal_lahir;
            }
            
            $user->save();
            
            DB::commit();
            
            return response()->json(['success' => 'Profile updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error updating profile: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Delete a profile and its files.
     */
    public function destroy($id)
    {
        $profile = MenteeProfile::findOrFail($id);
        $user = User::findOrFail($profile->user_id);
        
        DB::beginTransaction();
        try {
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
            if ($profile->gambar_laporan) {
                Storage::disk('public')->delete($profile->gambar_laporan);
            }
            
            $profile->delete();
            $user->delete();
            
            DB::commit();
            return response()->json(['success' => 'Profile deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error deleting profile: ' . $e->getMessage()], 500);
        }
    }
}