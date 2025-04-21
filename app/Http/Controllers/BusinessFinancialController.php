<?php

namespace App\Http\Controllers;

use App\Models\Hpp_;
use App\Models\BiyayaOps_;
use App\Models\NettProfit_;
use App\Models\GrossProfit_;
use Illuminate\Http\Request;
use App\Models\BusinessFinancial;
use App\Models\NettProfitMargin_;
use App\Models\GrossProfitMargin_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class BusinessFinancialController extends Controller
{
    /**
     * Menampilkan semua data financial bisnis
     */
    public function index()
    {
        Log::info('BusinessFinancialController@index called');
        try {
            $financials = BusinessFinancial::with([
                'hpp',
                'biyayaOps',
                'grossProfit',
                'nettProfit',
                'grossProfitMargin',
                'nettProfitMargin',
                'capaianTargetNeetProfit',
                'company'
            ])->paginate(10);

            Log::info('Fetched business financials successfully', ['count' => $financials->count()]);

            return response()->json($financials);
        } catch (\Exception $e) {
            Log::error('Error fetching business financials', ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Menyimpan data financial baru
     */
    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses store business financial', ['request' => $request->all()]);
    
            $validated = $this->validateRequest($request);
            Log::info('Validasi data berhasil', ['validated' => $validated]);
    
            DB::beginTransaction();
    
            $hpp = Hpp_::create([
                'targert_' => $validated['hpp']['target'],
                'realisasi_' => $validated['hpp']['realisasi']
            ]);
            Log::info('Data HPP berhasil dibuat', ['hpp' => $hpp]);
    
            $biyayaOps = BiyayaOps_::create([
                'targert_' => $validated['biyaya_ops']['target'],
                'realisasi_' => $validated['biyaya_ops']['realisasi']
            ]);
            Log::info('Data Biaya Operasional berhasil dibuat', ['biyaya_ops' => $biyayaOps]);
    
            $grossProfit = GrossProfit_::create([
                'targert_' => $validated['gross_profit']['target'],
                'realisasi_' => $validated['gross_profit']['realisasi']
            ]);
            Log::info('Data Gross Profit berhasil dibuat', ['gross_profit' => $grossProfit]);
    
            $grossProfitMargin = GrossProfitMargin_::create([
                'targert_' => $validated['gross_profit_margin']['target'],
                'realisasi_' => $validated['gross_profit_margin']['realisasi']
            ]);
            Log::info('Data Gross Profit Margin berhasil dibuat', ['gross_profit_margin' => $grossProfitMargin]);
    
            $nettProfit = NettProfit_::create([
                'targert_' => $validated['nett_profit']['target'],
                'realisasi_' => $validated['nett_profit']['realisasi']
            ]);
            Log::info('Data Nett Profit berhasil dibuat', ['nett_profit' => $nettProfit]);
    
            $nettProfitMargin = NettProfitMargin_::create([
                'targert_' => $validated['nett_profit_margin']['target'],
                'realisasi_' => $validated['nett_profit_margin']['realisasi']
            ]);
            Log::info('Data Nett Profit Margin berhasil dibuat', ['nett_profit_margin' => $nettProfitMargin]);
    
            $businessFinancial = BusinessFinancial::create([
                'hpp__id' => $hpp->id,
                'biyaya_ops__id' => $biyayaOps->id,
                'gross_profit__id' => $grossProfit->id,
                'nett_profit__id' => $nettProfit->id,
                'gross_profit_margin__id' => $grossProfitMargin->id,
                'nett_profit_margin__id' => $nettProfitMargin->id,
                'capaian_target_nett_profit' => $validated['capaian_target_nett_profit'],
                'company_id' => $validated['company_id'],
                'realisasi' => $validated['realisasi']
            ]);
            Log::info('Data Business Financial berhasil dibuat', ['business_financial' => $businessFinancial]);
    
            DB::commit();
    
            return response()->json(
                $businessFinancial->load([
                    'hpp',
                    'biyayaOps',
                    'grossProfit',
                    'nettProfit',
                    'grossProfitMargin',
                    'nettProfitMargin',
                    'capaianTargetNettProfit' => 'capaian_target_nett_profit',
                    'company'
                ]),
                201
            );
        } catch (ValidationException $e) {
            Log::warning('Validasi gagal', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan business financial', ['exception' => $e]);
            return response()->json(['error' => 'Create failed: ' . $e->getMessage()], 500);
        }
    }
    

    /**
     * Menampilkan detail financial bisnis
     */
    public function show($id)
    {
        Log::info('BusinessFinancialController@show called', ['id' => $id]);
        try {
            $financial = BusinessFinancial::with([
                'hpp',
                'biyayaOps',
                'grossProfit',
                'nettProfit',
                'grossProfitMargin',
                'nettProfitMargin',
                'capaianTargetNeetProfit',
                'company'
            ])->findOrFail($id);

            Log::info('Fetched business financial detail', ['id' => $id]);
            return response()->json($financial);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Business financial not found', ['id' => $id]);
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching business financial detail', ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update data financial bisnis
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $this->validateRequest($request);
            
            DB::beginTransaction();
            
            $businessFinancial = BusinessFinancial::findOrFail($id);
            
            // Update semua tabel terkait
            $this->updateRelated($businessFinancial->hpp__id, Hpp_::class, $validated['hpp']);
            $this->updateRelated($businessFinancial->biyaya_ops__id, BiyayaOps_::class, $validated['biyaya_ops']);
            $this->updateRelated($businessFinancial->gross_profit__id, GrossProfit_::class, $validated['gross_profit']);
            $this->updateRelated($businessFinancial->gross_profit_margin__id, GrossProfitMargin_::class, $validated['gross_profit_margin']);
            $this->updateRelated($businessFinancial->nett_profit__id, NettProfit_::class, $validated['nett_profit']);
            $tis->updateRelated($businessFinancial->nett_profit_margin__id, NettProfitMargin_::class, $validated['nett_profit_margin']);       
            
            $businessFinancial->update([
                'capaian_target_nett_profit' => $validated['capaian_target_nett_profit'],
                'realisasi' => $validated['realisasi'],
                'company_id' => $validated['company_id']
            ]);
            
            DB::commit();
            
            return response()->json(
                $businessFinancial->load([
                    'hpp',
                    'biyayaOps',
                    'grossProfit',
                    'nettProfit',
                    'grossProfitMargin',
                    'nettProfitMargin',
                    'capaianTargetNeetProfit',
                    'company'
                ])
            );
            
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus data financial bisnis
     */
    public function destroy($id)
    {
        Log::info('BusinessFinancialController@destroy called', ['id' => $id]);
        try {
            DB::beginTransaction();
            
            $financial = BusinessFinancial::findOrFail($id);
            $financial->delete();
            Log::info('Deleted business financial record', ['id' => $id]);
            
            DB::commit();
            
            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Attempted to delete non-existent business financial', ['id' => $id]);
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception when deleting business financial', ['exception' => $e]);
            return response()->json(['error' => 'Delete failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Validasi request
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'hpp.target' => 'required|integer',
            'hpp.realisasi' => 'required|integer',
            'biyaya_ops.target' => 'required|integer',
            'biyaya_ops.realisasi' => 'required|integer',
            'gross_profit.target' => 'required|integer',
            'gross_profit.realisasi' => 'required|integer',
            'nett_profit.target' => 'required|integer',
            'nett_profit.realisasi' => 'required|integer',
            'gross_profit_margin.target' => 'required|integer',
            'gross_profit_margin.realisasi' => 'required|integer',
            'nett_profit_margin.target' => 'required|integer',
            'nett_profit_margin.realisasi' => 'required|integer',
            'capaian_target_nett_profit' => 'required|integer',
            'company_id' => 'required|exists:companies,id',
            'realisasi' => 'required|integer'
        ]);
    }

    private function updateRelated($id, $model, $data)
    {
        $record = $model::findOrFail($id);
        $record->update([
            'target_' => $data['target'],
            'realisasi_' => $data['realisasi']
        ]);
        return $record;
    }
}
