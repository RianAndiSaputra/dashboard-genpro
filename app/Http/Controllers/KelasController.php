<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class KelasController extends Controller
{
    // Get all kelas dengan relasi
    public function index()
    {
        Log::info('Memulai proses pengambilan data kelas');
    
        try {
            $kelas = Kelas::with(['mentor', 'secretary', 'mentee'])->get();
    
            Log::info('Data kelas berhasil diambil', [
                'jumlah_kelas' => $kelas->count()
            ]);
    
            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data kelas', [
                'error' => $e->getMessage()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data kelas'
            ], 500);
        }
    }
    // Membuat kelas baru
    public function store(Request $request)
    {
        // Log awal request
        Log::info('Menerima request untuk membuat kelas', $request->all());
    
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'mentor_id' => [
                'required',
                Rule::exists('users', 'user_id')->where(function ($query) {
                    $query->where('role', 'mentor');
                }),
            ],
            'secretary_id' => [
                'required',
                Rule::exists('users', 'user_id')->where(function ($query) {
                    $query->where('role', 'secretary');
                }),
            ],
            'mentee_id' => [
                'nullable',
                Rule::exists('users', 'user_id')->where(function ($query) {
                    $query->where('role', 'mentee');
                }),
            ],
        ]);
    
        if ($validator->fails()) {
            Log::warning('Validasi gagal saat membuat kelas', [
                'errors' => $validator->errors()->toArray()
            ]);
    
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $kelas = Kelas::create($request->only(['class_name', 'mentor_id', 'secretary_id', 'mentee_id']));
    
            Log::info('Kelas berhasil dibuat', [
                'kelas' => $kelas
            ]);
    
            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ], 201);
        } catch (\Exception $e) {
            Log::error('Gagal membuat kelas', [
                'error' => $e->getMessage()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat kelas'
            ], 500);
        }
    }

    // Get detail kelas
    public function show($id)
    {
        try {
            $kelas = Kelas::with(['mentor', 'secretary', 'mentees'])->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ], 200);
        } catch (\Exception $e) {
            // Log error detail
            Log::error('Error mengambil detail kelas', [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }
    }

    // Update kelas
    public function update(Request $request, $id)
    {
        Log::info('Menerima request untuk update kelas', ['id' => $id, 'request' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'class_name' => 'sometimes|string|max:255',
            'mentor_id' => [
                'sometimes',
                Rule::exists('users', 'user_id')->where(function ($query) {
                    $query->where('role', 'mentor');
                }),
            ],
            'secretary_id' => [
                'sometimes',
                Rule::exists('users', 'user_id')->where(function ($query) {
                    $query->where('role', 'secretary');
                }),
            ],
            'mentee_id' => [
                'nullable',
                Rule::exists('users', 'user_id')->where(function ($query) {
                    $query->where('role', 'mentee');
                }),
            ],
        ]);

        if ($validator->fails()) {
            Log::warning('Validasi gagal saat update kelas', [
                'errors' => $validator->errors()->toArray()
            ]);

            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kelas = Kelas::findOrFail($id);
            $kelas->update($request->only(['class_name', 'mentor_id', 'secretary_id', 'mentee_id']));

            Log::info('Kelas berhasil diupdate', ['kelas' => $kelas]);

            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal update kelas', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal update kelas'
            ], 500);
        }
    }

    // Hapus kelas
    public function destroy($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $kelas->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Kelas berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus kelas'
            ], 500);
        }
    }
}
