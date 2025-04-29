<?php

namespace App\Http\Controllers;

use App\Models\Company;
use APp\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('user')->get();
        return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nama_perusahaan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_wa' => 'required|string|max:20',
        ]);

        $company = Company::create($request->all());

        return response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::with('user')->findOrFail($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     */
    // Bagian method update()
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'user_id' => 'sometimes|exists:users,user_id', // Diubah ke 'user_id'
            'nama_perusahaan' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'nomor_wa' => 'sometimes|string|max:20',
        ]);

        $company->update($request->all());

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(["massage"=>"berhasil di hapus"]);
    }

    public function searchOwners(Request $request)
    {
        $query = $request->input('q');
        
        $users = User::where('full_name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(10)
                    ->get(['user_id', 'full_name as name', 'email']);
        
        return response()->json($users);
    }
}
