<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MutabaahReport;

class MutabahReportController extends Controller
{
    public function index()
    {
        $reports = MutabaahReport::with('mentee.user')->get();
        return response()->json($reports);
    }

    /**
     * Menyimpan laporan mutabaah baru.
     */
    public function store(Request $request)
    {
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

        $report = MutabaahReport::create($validated);

        return response()->json([
            'message' => 'Laporan mutabaah berhasil disimpan.',
            'data' => $report
        ], 201);
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
}
