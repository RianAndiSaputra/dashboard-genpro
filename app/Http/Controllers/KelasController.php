<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use App\Models\MenteeProfile;

class KelasController extends Controller
{
    // Get all kelas dengan relasi
    // Contoh di controller
    public function index()
    {
        // Ambil mentor dan secretary dengan kolom yang konsisten
        $mentors = User::select('user_id', 'full_name')->where('role', 'mentor')->get();
        $secretaries = User::select('user_id', 'full_name')->where('role', 'secretary')->get();
        $mentees = User::where('role', 'mentee')->get();
        $kelas = Kelas::with('mentor', 'secretary')->paginate(10);
        
        return view('dashboard.daftar-kelas', compact('mentors', 'secretaries', 'kelas', 'mentees'));
    }
    

    public function create()
    {
        // Ambil mentee yang sudah memiliki profil
        $mentees = MenteeProfile::with('user')
                    ->whereDoesntHave('kelas') // Hanya yang belum memiliki kelas
                    ->get()
                    ->map(function($mentee) {
                        return [
                            'id' => $mentee->user_id,
                            'full_name' => $mentee->user->full_name,
                            'company' => $mentee->company->nama_perusahaan ?? '-'
                        ];
                    });

        return view('dashboard.daftar-kelas', compact('mentees'));
    }

    // Membuat kelas baru
    public function store(Request $request)
    {
        // Log request data untuk debugging
        Log::info('[Kelas] Memulai proses pembuatan kelas baru', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
            'has_file' => $request->hasFile('pdf_file'),
            'all_files' => $request->allFiles()
        ]);
    
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'kategori_kelas' => 'required|in:Online,Tatap Muka,Hybrid',
            'lokasi_zoom' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:Aktif,Dijadwalkan,Selesai',
            'deskripsi_kelas' => 'nullable|string',
            'kuota_peserta' => 'required|integer|min:1',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // Field wajib diubah jadi nullable
            'mentor_id' => [
                'required',
                Rule::exists('users', 'user_id')->where('role', 'mentor'),
            ],
            'secretary_id' => [
                'required',
                Rule::exists('users', 'user_id')->where('role', 'secretary'),
            ],
            'mentee_id' => [
                'nullable',
                Rule::exists('users', 'user_id')->where('role', 'mentee'),
            ],
        ]);
    
        if ($validator->fails()) {
            Log::warning('[Kelas] Validasi gagal', [
                'errors' => $validator->errors(),
                'input' => $request->except('pdf_file')
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
        DB::beginTransaction();
        try {
            $pdfPath = null; // Default null jika tidak ada file
            
            // Cek apakah ada file PDF yang dikirim dan valid
            if ($request->hasFile('pdf_file') && $request->file('pdf_file')->isValid()) {
                $pdfPath = $request->file('pdf_file')->store('kelas/pdf', 'public');
                Log::info('[Kelas] PDF berhasil diupload', [
                    'file_name' => $request->file('pdf_file')->getClientOriginalName(),
                    'stored_path' => $pdfPath
                ]);
            }
    
            $kelas = Kelas::create([
                'class_name' => $request->class_name,
                'kategori_kelas' => $request->kategori_kelas,
                'lokasi_zoom' => $request->lokasi_zoom,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
                'deskripsi_kelas' => $request->deskripsi_kelas,
                'kuota_peserta' => $request->kuota_peserta,
                'pdf_path' => $pdfPath,
                'mentor_id' => $request->mentor_id,
                'secretary_id' => $request->secretary_id,
                'mentee_id' => $request->mentee_id
            ]);
    
            DB::commit();
    
            Log::info('[Kelas] Kelas berhasil dibuat', [
                'kelas_id' => $kelas->id
            ]);
    
            return response()->json([
                'status' => 'success',
                'data' => $kelas,
                'pdf_url' => $pdfPath ? asset("storage/$pdfPath") : null
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus file yang sudah terupload jika gagal
            if (isset($pdfPath) && $pdfPath) {
                Storage::delete("public/$pdfPath");
            }
    
            Log::error('[Kelas] Gagal menyimpan kelas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat kelas',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }

    // Get detail kelas
    public function show($id)
    {
        Log::info('[Kelas] Mencari detail kelas', [
            'kelas_id' => $id
        ]);
        
        try {
            $kelas = Kelas::with(['mentor', 'secretary', 'mentees.user',])->findOrFail($id);
            
            Log::info('[Kelas] Detail kelas berhasil diambil', [
                'kelas_id' => $id
            ]);
            
            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('[Kelas] Kelas tidak ditemukan', [
                'kelas_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('[Kelas] Error mengambil detail kelas', [
                'kelas_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil detail kelas'
            ], 500);
        }
    }

    // Update kelas
    public function update(Request $request, $id)
    {
        Log::info('[Kelas] Memulai proses update kelas', [
            'kelas_id' => $id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $request->except(['password', 'token']),
            'has_file' => $request->hasFile('pdf_file'),
            'timestamp' => now()->toDateTimeString()
        ]);

        $validator = Validator::make($request->all(), [
            'class_name' => 'sometimes|string|max:255',
            'kategori_kelas' => 'sometimes|in:Online,Tatap Muka,Hybrid',
            'lokasi_zoom' => 'nullable|string',
            'tanggal_mulai' => 'sometimes|date',
            'tanggal_selesai' => 'sometimes|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'sometimes|date_format:H:i',
            'jam_selesai' => 'sometimes|date_format:H:i|after:jam_mulai',
            'status' => 'sometimes|in:Aktif,Dijadwalkan,Selesai',
            'deskripsi_kelas' => 'nullable|string',
            'kuota_peserta' => 'sometimes|integer|min:1',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'mentor_id' => [
                'sometimes',
                Rule::exists('users', 'user_id')->where('role', 'mentor'),
            ],
            'secretary_id' => [
                'sometimes',
                Rule::exists('users', 'user_id')->where('role', 'secretary'),
            ],
            'mentee_id' => [
                'nullable',
                Rule::exists('users', 'user_id')->where('role', 'mentee'),
            ],
        ]);

        if ($validator->fails()) {
            Log::warning('[Kelas] Validasi update kelas gagal', [
                'kelas_id' => $id,
                'errors' => $validator->errors()->toArray(),
                'invalid_data' => $validator->invalid()
            ]);

            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'kelas_id' => $id
            ], 422);
        }

        try {
            DB::beginTransaction();

            $kelas = Kelas::findOrFail($id);
            
            // Log original values before update
            Log::debug('[Kelas] Data kelas sebelum update', [
                'kelas_id' => $kelas->id,
                'original_data' => $kelas->getOriginal(),
                'changes_requested' => $request->except(['password', 'token'])
            ]);

            $updateData = $request->only([
                'class_name',
                'kategori_kelas',
                'lokasi_zoom',
                'tanggal_mulai',
                'tanggal_selesai',
                'jam_mulai',
                'jam_selesai',
                'status',
                'deskripsi_kelas',
                'kuota_peserta',
                'mentor_id',
                'secretary_id',
                'mentee_id'
            ]);

            // Handle PDF file upload if provided
            if ($request->hasFile('pdf_file') && $request->file('pdf_file')->isValid()) {
                // Log PDF upload attempt
                Log::debug('[Kelas] Mencoba upload PDF untuk update', [
                    'kelas_id' => $id,
                    'file_name' => $request->file('pdf_file')->getClientOriginalName(),
                    'file_size' => $request->file('pdf_file')->getSize()
                ]);
                
                // Delete existing PDF if present
                if ($kelas->pdf_path) {
                    Storage::disk('public')->delete($kelas->pdf_path);
                    Log::debug('[Kelas] PDF lama dihapus', [
                        'kelas_id' => $id,
                        'old_path' => $kelas->pdf_path
                    ]);
                }
                
                // Store the new PDF file
                $pdfPath = $request->file('pdf_file')->store('kelas/pdf', 'public');
                $updateData['pdf_path'] = $pdfPath;
                
                Log::info('[Kelas] PDF berhasil diupload pada update', [
                    'kelas_id' => $id,
                    'file_name' => $request->file('pdf_file')->getClientOriginalName(),
                    'stored_path' => $pdfPath
                ]);
            }

            $kelas->update($updateData);

            // Log after successful update
            Log::info('[Kelas] Kelas berhasil diupdate', [
                'kelas_id' => $kelas->id,
                'updated_fields' => array_keys($updateData),
                'changes' => $kelas->getChanges(),
                'updated_by' => optional(auth()->user())->id,
                'updated_at' => now()->toDateTimeString()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $kelas,
                'changes' => $kelas->getChanges()
            ], 200);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            
            Log::error('[Kelas] Kelas tidak ditemukan', [
                'kelas_id' => $id,
                'error' => $e->getMessage(),
                'request_data' => $request->except(['password', 'token'])
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Kelas tidak ditemukan',
                'kelas_id' => $id
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('[Kelas] Gagal update kelas', [
                'kelas_id' => $id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'token'])
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal update kelas',
                'system_message' => $e->getMessage(),
                'kelas_id' => $id
            ], 500);
        }
    }

    // Hapus kelas
    public function destroy($id)
    {
        Log::info('[Kelas] Memulai proses hapus kelas', [
            'kelas_id' => $id
        ]);
        
        try {
            DB::beginTransaction();
            
            $kelas = Kelas::findOrFail($id);
            
            // Hapus file PDF jika ada
            if ($kelas->pdf_path) {
                Storage::disk('public')->delete($kelas->pdf_path);
                Log::info('[Kelas] PDF kelas berhasil dihapus', [
                    'kelas_id' => $id,
                    'pdf_path' => $kelas->pdf_path
                ]);
            }
            
            $kelas->delete();
            
            DB::commit();
            
            Log::info('[Kelas] Kelas berhasil dihapus', [
                'kelas_id' => $id
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Kelas berhasil dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            
            Log::error('[Kelas] Kelas tidak ditemukan untuk dihapus', [
                'kelas_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('[Kelas] Gagal menghapus kelas', [
                'kelas_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus kelas',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }
    // Di controller
    public function tambahPeserta(Request $request)
    {
        try {
            $validated = $request->validate([
                'kelas_id' => 'required|exists:kelas,id',
                'user_id' => 'required|exists:users,user_id'
            ]);
    
            // Cek apakah user sudah terdaftar di kelas ini
            $existingInClass = MenteeProfile::where('user_id', $validated['user_id'])
                                        ->where('kelas_id', $validated['kelas_id'])
                                        ->exists();
    
            if ($existingInClass) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Peserta sudah terdaftar di kelas ini'
                ], 422);
            }
    
            // Ambil data mentee yang sudah ada
            $existingMentee = MenteeProfile::where('user_id', $validated['user_id'])
                                        ->latest() // Ambil yang terbaru
                                        ->firstOrFail();
    
            // Buat record baru dengan data yang sama, hanya update kelas_id dan status
            $newMentee = $existingMentee->replicate();
            $newMentee->kelas_id = $validated['kelas_id'];
            $newMentee->status_kelas = 'aktif';
            $newMentee->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Peserta berhasil ditambahkan ke kelas'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan peserta: ' . $e->getMessage()
            ], 500);
        }
    }
    
    

    public function getPeserta(Kelas $kelas)
    {
        $mentees = $kelas->mentees()
            ->with('user:user_id,full_name,email,phone')
            ->paginate(10);
    
        return response()->json([
            'data' => $mentees->items(),
            'current_page' => $mentees->currentPage(),
            'total' => $mentees->total()
        ]);
    }
    
    public function updateStatus(MenteeProfile $mentee, Request $request)
    {
        $request->validate(['status' => 'required|in:aktif,nonaktif']);
        
        $mentee->update(['status_kelas' => $request->status]);
        
        return response()->json(['success' => true]);
    }

    // In KelasController.php

// Get mentee detail
public function getMentee($id)
{
    try {
        $mentee = MenteeProfile::with('user')->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $mentee
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Peserta tidak ditemukan'
        ], 404);
    }
}

// Update mentee status
public function updateMentee(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:aktif,nonaktif'
    ]);

    try {
        $mentee = MenteeProfile::findOrFail($id);
        $mentee->update(['status_kelas' => $request->status]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status peserta berhasil diperbarui'
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Peserta tidak ditemukan'
        ], 404);
    }
}

// Delete mentee
public function destroyMentee($id)
{
    try {
        $mentee = MenteeProfile::findOrFail($id);
        $mentee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Peserta berhasil dihapus'
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Peserta tidak ditemukan'
        ], 404);
    }
}
    
}