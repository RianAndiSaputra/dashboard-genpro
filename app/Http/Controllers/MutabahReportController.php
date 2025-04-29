<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenteeProfile;
use App\Models\MutabaahReport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MutabahReportController extends Controller
{

    public function mentee()
    {
        $user = auth()->user();

        // Cek apakah user adalah mentee
        if (strtolower($user->role) !== 'mentee') {
            return redirect()->back()->with('error', 'Hanya mentee yang dapat mengakses halaman ini.');
        }

        // Ambil profil mentee dari user yang login
        $menteeProfile = $user->menteeProfile;
        
        // Handle jika tidak ada profil mentee
        if (!$menteeProfile) {
            return redirect()->back()->with('error', 'Profil mentee tidak ditemukan.');
        }

        // Ambil laporan hanya untuk mentee yang login
        $reports = MutabaahReport::where('mentee_id', $menteeProfile->id)
            ->with('mentee.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mente.mutabaah', compact('reports'));
    }

    public function index()
    {
        $reports = MutabaahReport::with('mentee.user')->get();

        return view('dashboard.mutabaah', compact('reports'));

        return response()->json([
            'status' => 'success',
            'message' => 'data succesfuly retrivied',
            'data' => $reports
        ]);
    }

    /**
     * Menyimpan laporan mutabaah baru.
     */
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            \Log::info('User ID: ' . $user->user_id);
    
            // Pengecekan role (case-insensitive)
            if (strtolower($user->role) !== 'mentee') {
                \Log::warning('Akses ditolak. Role bukan mentee.', ['role' => $user->role]);
                return response()->json([
                    'message' => 'Hanya mentee yang dapat membuat laporan mutabaah.'
                ], 403);
            }
    
            // Menggunakan relasi untuk mendapatkan mentee profile
            $menteeProfile = $user->menteeProfile;
            if (!$menteeProfile) {
                \Log::warning('Profil mentee tidak ditemukan.', ['user_id' => $user->user_id]);
                return response()->json([
                    'message' => 'Profil mentee tidak ditemukan.'
                ], 404);
            }
    
            // Validasi input
            $validated = $request->validate([
                'solat_berjamaah' => 'required|in:IYA,TIDAK',
                'baca_quraan'     => 'required|in:IYA,TIDAK',
                'solat_duha'      => 'required|in:IYA,TIDAK',
                'puasa_sunnah'    => 'required|in:IYA,TIDAK',
                'sodaqoh_subuh'   => 'required|in:IYA,TIDAK',
                'relasibaru'      => 'required|in:IYA,TIDAK',
                'menabung'       => 'required|in:IYA,TIDAK',
                'penjualan'      => 'required|in:IYA,TIDAK',
            ]);
    
            // Menambahkan mentee_id ke data
            $validated['mentee_id'] = $menteeProfile->id;
    
            // Membuat laporan
            $report = MutabaahReport::create($validated);
    
            // Response
            return response()->json([
                'message' => 'Laporan mutabaah berhasil disimpan.',
                'mentee'  => [
                    'id'   => $menteeProfile->id,
                    'name' => $user->full_name
                ],
                'data'    => $report
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validasi gagal: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Kesalahan server: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan laporan.',
                'error'   => env('APP_DEBUG') ? $e->getMessage() : 'Silakan coba lagi.'
            ], 500);
        }
    }
    

    /**
     * Menampilkan detail satu laporan mutabaah.
     */
    public function show($id)
    {
        $report = MutabaahReport::with('mentee.user')->findOrFail($id);

        return response()->json($report);
    }

    /**
     * Memperbarui laporan mutabaah.
     */
    public function update(Request $request, $id)
    {
        $report = MutabaahReport::findOrFail($id);

        $validated = $request->validate([
            'mentee_id' => 'required|exists:mentee_profiles,id',
            'solat_berjamaah' => 'required|in:IYA,TIDAK',
            'baca_quraan' => 'required|in:IYA,TIDAK',
            'solat_duha' => 'required|in:IYA,TIDAK',
            'puasa_sunnah' => 'required|in:IYA,TIDAK',
            'sodaqoh_subuh' => 'required|in:IYA,TIDAK',
            'relasibaru' => 'required|in:IYA,TIDAK',
            'menabung' => 'required|in:IYA,TIDAK',
            'penjualan' => 'required|in:IYA,TIDAK',
        ]);

        $report->update($validated);

        return response()->json([
            'message' => 'Laporan mutabaah berhasil diperbarui.',
            'data' => $report
        ]);
    }

    /**
     * Menghapus laporan mutabaah.
     */
    public function destroy($id)
    {
        $report = MutabaahReport::findOrFail($id);
        $report->delete();

        return response()->json([
            'message' => 'Laporan mutabaah berhasil dihapus.'
        ]);
    }

    public function exportCSV()
    {
        $reports = MutabaahReport::with(['mentee.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=mutabaah_reports_" . date('Y-m-d') . ".csv",
            "Pragma"             => "no-cache",
            "Cache-Control"      => "must-revalidate, post-check=0, pre-check=0",
            "Expires"            => "0"
        ];

        $columns = [
            'No', 
            'Tanggal', 
            'Nama Mentee',
            'Sholat Jamaah',
            'Baca Quran',
            'Sholat Dhuha',
            'Puasa Sunnah',
            'Sedekah Subuh',
            'Relasi Baru',
            'Menabung',
            'Penjualan'
        ];

        $callback = function() use($reports, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($reports as $index => $report) {
                $row = [
                    $index + 1,
                    $report->created_at->format('d/m/Y'),
                    $report->mentee->user->full_name ?? 'Tidak diketahui',
                    $report->solat_berjamaah,
                    $report->baca_quraan,
                    $report->solat_duha,
                    $report->puasa_sunnah,
                    $report->sodaqoh_subuh,
                    $report->relasibaru,
                    $report->menabung,
                    $report->penjualan
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
