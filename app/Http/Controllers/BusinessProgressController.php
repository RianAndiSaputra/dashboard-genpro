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
    public function index()
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

            return response()->json([
                'status' => 'success',
                'message' => 'Data retrieved successfully',    
                'data' => $progress
            ]);
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
            $nettMargin = NettProfitMargin::create($validated['nett_profit_marign']);

            // Create main progress record
            $progress = BusinessProgress::create([
                'omzet_id' => $omzet->id,
                'hpp_id' => $hpp->id,
                'biayaops_id' => $biayaops->id,
                'gross_profit_id' => $grossProfit->id,
                'net_profit_id' => $netProfit->id,
                'gross_profit_margin_id' => $grossMargin->id,
                'nett_profit_marign_id' => $nettMargin,
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

}
