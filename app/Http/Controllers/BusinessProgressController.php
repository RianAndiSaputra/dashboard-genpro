<?php

namespace App\Http\Controllers;

use App\Models\Hpp;
use App\Models\Omzet;
use App\Models\Biayaops;
use App\Models\NetProfit;
use App\Models\GrossProfit;
use Illuminate\Http\Request;
use App\Models\BusinessProgress;
use App\Models\NettProfitMargin;
use App\Models\GrossProfitMargin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BusinessProgressController extends Controller
{

    public function businessMentee()
    {
        try {
            $user = auth()->user();

            // Cek role user
            // if (strtolower($user->role) !== 'mentee') {
            //     return redirect()->back()->with('error', 'Hanya mentee yang dapat mengakses halaman ini.');
            // }

            // Ambil profil mentee
            $menteeProfile = $user->menteeProfile;
            if (!$menteeProfile) {
                return redirect()->back()->with('error', 'Profil mentee tidak ditemukan.');
            }

            // Ambil company_id dari mentee
            $companyId = $menteeProfile->company_id;
            if (!$companyId) {
                return redirect()->back()->with('error', 'Mentee belum terdaftar di perusahaan.');
            }

            // Ambil data progress berdasarkan company_id
            $progress = BusinessProgress::with([
                    'omzet',
                    'hpp',
                    'biayaops',
                    'grossProfit',
                    'netProfit',
                    'grossProfitMargin',
                    'nettProfitMargin',
                    'company'
                ])
                ->where('company_id', $companyId)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('mente.Summary-Financial', compact('progress'));

        } catch (\Exception $e) {
            Log::error('Error fetching business progress: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan server');
        }
    }

    public function businessAdmin()
    {
        try {
            $progress = BusinessProgress::with([
                'omzet',
                'hpp',
                'biayaops',
                'grossProfit',
                'netProfit',
                'grossProfitMargin',
                'nettProfitMargin',
                'company'
            ])->get();

            return view ('dashboard.Summary-Financial', compact('progress'));
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Data retrieved successfully',    
            //     'data' => $progress
            // ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $progress = BusinessProgress::with([
                'omzet',
                'hpp',
                'biayaops', 
                'grossProfit',
                'netProfit',
                'grossProfitMargin',
                'nettProfitMargin',
                'company'
            ])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => $progress
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
    // Create new progress
    public function store(Request $request)
    {
        try {
            $validated = $this->validateRequest($request);

            DB::beginTransaction();

            // Create related records
            $omzet = Omzet::create($validated['omzet']);
            $hpp = Hpp::create($validated['hpp']);
            $biayaops = Biayaops::create($validated['biayaops']);
            $grossProfit = GrossProfit::create($validated['gross_profit']);
            $netProfit = NetProfit::create($validated['net_profit']);
            $grossMargin = GrossProfitMargin::create($validated['gross_profit_margin']);
            $nettMargin = NettProfitMargin::create($validated['nett_profit_margin']);

            // Create main progress record
            $progress = BusinessProgress::create([
                'omzet_id' => $omzet->id,
                'hpp_id' => $hpp->id,
                'biayaops_id' => $biayaops->id,
                'gross_profit_id' => $grossProfit->id,
                'net_profit_id' => $netProfit->id,
                'gross_profit_margin_id' => $grossMargin->id,
                'nett_profit_margin_id' => $nettMargin->id,
                'company_id' => $validated['company_id']
            ]);

            DB::commit();

            return response()->json($progress, 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Creation failed: ' . $e->getMessage()], 500);
        }
    }

    // Update progress
    public function update(Request $request, $id)
    {
        try {
            $validated = $this->validateRequest($request);

            DB::beginTransaction();

            $progress = BusinessProgress::findOrFail($id);

            // Update related records
            $this->updateRelated($progress->omzet_id, Omzet::class, $validated['omzet']);
            $this->updateRelated($progress->hpp_id, Hpp::class, $validated['hpp']);
            

            DB::commit();

            return response()->json($progress->loadAllRelations());

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    // Validation rules
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'omzet.targert' => 'required|integer',
            'omzet.realisasi' => 'required|integer',
            'hpp.targert' => 'required|integer',
            'hpp.realisasi' => 'required|integer',
            'biayaops.targert' => 'required|integer',
            'biayaops.realisasi' => 'required|integer',
            'gross_profit.targert' => 'required|integer',
            'gross_profit.realisasi' => 'required|integer',
            'net_profit.targert' => 'required|integer',
            'net_profit.realisasi' => 'required|integer',
            'gross_profit_margin.targert' => 'required|integer',
            'gross_profit_margin.realisasi' => 'required|integer',
            'nett_profit_margin.targert' => 'required|integer',
            'nett_profit_margin.realisasi' => 'required|integer',
            'company_id' => 'required|exists:companies,id'
        ]);
    }

    // Helper untuk update related models
    private function updateRelated($id, $modelClass, $data)
    {
        $model = $modelClass::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function exportCsv(Request $request)
{
    try {
        // Query database untuk mendapatkan semua laporan keuangan
        $reports = BusinessProgress::with([
            'company', 
            'omzet', 
            'hpp', 
            'biayaops', 
            'grossProfit', 
            'netProfit', 
            'grossProfitMargin', 
            'nettProfitMargin'
        ])->get();
        
        // Nama file
        $filename = 'laporan_keuangan_' . date('Y-m-d_His') . '.csv';
        
        // Buat response dengan header untuk download file CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        // Buat callback untuk stream file CSV
        $callback = function() use ($reports) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                // 'ID', 
                'Perusahaan', 
                'Omzet (Target)', 
                'Omzet (Realisasi)', 
                'HPP (Target)', 
                'HPP (Realisasi)', 
                'Biaya Operasional (Target)', 
                'Biaya Operasional (Realisasi)', 
                'Gross Profit (Target)', 
                'Gross Profit (Realisasi)', 
                'Net Profit (Target)', 
                'Net Profit (Realisasi)', 
                'Gross Profit Margin (Target %)', 
                'Gross Profit Margin (Realisasi %)', 
                'Net Profit Margin (Target %)', 
                'Net Profit Margin (Realisasi %)',
                'Tanggal Dibuat'
            ]);
            
            // Isi CSV dengan data
            foreach ($reports as $report) {
                fputcsv($file, [
                    // $report->id,
                    $report->company->nama_perusahaan ?? 'N/A',
                    $report->omzet->targert ?? 0,
                    $report->omzet->realisasi ?? 0,
                    $report->hpp->targert ?? 0,
                    $report->hpp->realisasi ?? 0,
                    $report->biayaops->targert ?? 0,
                    $report->biayaops->realisasi ?? 0,
                    $report->grossProfit->targert ?? 0,
                    $report->grossProfit->realisasi ?? 0,
                    $report->netProfit->targert ?? 0,
                    $report->netProfit->realisasi ?? 0,
                    $report->grossProfitMargin->targert ?? 0,
                    $report->grossProfitMargin->realisasi ?? 0,
                    $report->nettProfitMargin->targert ?? 0,
                    $report->nettProfitMargin->realisasi ?? 0,
                    $report->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        // Kembalikan response dengan file CSV
        return response()->stream($callback, 200, $headers);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
    }
}

}
