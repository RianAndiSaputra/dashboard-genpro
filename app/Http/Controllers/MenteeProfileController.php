<?php

namespace App\Http\Controllers;

use App\Models\MenteeProfile;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MenteeProfileController extends Controller
{
    public function index()
    {
        $profiles = MenteeProfile::with(['user', 'company', 'kelas'])->get();
        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'company_id' => 'required|exists:companies,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bidang_usaha' => 'required|string',
            'badan_hukum' => 'required|string',
            'tahun_berdiri' => 'required|string',
            'jumlah_karyawan' => 'required|integer',
            'jumlah_omset' => 'required|integer',
            'jabatan' => 'required|string',
            'komitmen' => 'required|in:iya,tidak',
            'gambar_laporan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except(['profile_picture', 'gambar_laporan']);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('mentee_profiles', 'public');
        }

        // Handle laporan upload
        if ($request->hasFile('gambar_laporan')) {
            $data['gambar_laporan'] = $request->file('gambar_laporan')->store('mentee_reports', 'public');
        }

        $profile = MenteeProfile::create($data);

        return response()->json($profile, 201);
    }

    public function show($id)
    {
        try {
            $profile = MenteeProfile::with(['user', 'company', 'kelas'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $profile
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage() // Bisa dihapus kalau ingin lebih aman
            ], 500);
        }
    }
    

    public function update(Request $request, $id)
    {
        $profile = MenteeProfile::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,user_id',
            'company_id' => 'sometimes|exists:companies,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'address' => 'sometimes|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bidang_usaha' => 'sometimes|string',
            'badan_hukum' => 'sometimes|string',
            'tahun_berdiri' => 'sometimes|string',
            'jumlah_karyawan' => 'sometimes|integer',
            'jumlah_omset' => 'sometimes|integer',
            'jabatan' => 'sometimes|string',
            'komitmen' => 'sometimes|in:iya,tidak',
            'gambar_laporan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except(['profile_picture', 'gambar_laporan']);

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('mentee_profiles', 'public');
        }

        // Handle laporan update
        if ($request->hasFile('gambar_laporan')) {
            // Delete old image if exists
            if ($profile->gambar_laporan) {
                Storage::disk('public')->delete($profile->gambar_laporan);
            }
            $data['gambar_laporan'] = $request->file('gambar_laporan')->store('mentee_reports', 'public');
        }

        $profile->update($data);

        return response()->json($profile);
    }

    public function destroy($id)
    {
        $profile = MenteeProfile::findOrFail($id);

        // Delete associated files
        if ($profile->profile_picture) {
            Storage::disk('public')->delete($profile->profile_picture);
        }
        if ($profile->gambar_laporan) {
            Storage::disk('public')->delete($profile->gambar_laporan);
        }

        $profile->delete();

        return response()->json(["massage"=>"berhasil di hapus"]);
    }
}
