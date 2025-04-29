<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MenteeProfileController;
use App\Http\Controllers\MutabahReportController;
use App\Http\Controllers\BusinessFinancialController;
use App\Http\Controllers\BusinessProgressController;

Route::middleware(['auth:sanctum'])->group(function() {

    // Group untuk role: admin dan kepalaSekolah
    Route::middleware('role:admin,kepalaSekolah')->group(function() {

        Route::controller(UserController::class)->group(function() {
            Route::get('/user', 'index');
            Route::get('/detail/user/{id}', 'show');
            Route::put('/update/user/{id}', 'update');
            Route::post('/create/user', 'store');
            Route::delete('/delete/user/{id}', 'destroy');
        });

        Route::controller(MenteeProfileController::class)->group(function() {
            Route::get('/mentee', 'index');
            Route::get('/detail/mentee/{id}', 'show');
            Route::put('/update/mentee/{id}', 'update');
            Route::post('/create/mentee', 'store');
            Route::delete('/delete/mentee/{id}', 'destroy');
        });

        // Fungsi cari owner di tambah company
        Route::get('/search-users', function(\Illuminate\Http\Request $request) {
            $query = $request->input('q');

            return \App\Models\User::where('full_name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->select('user_id', 'full_name', 'email')
                    ->limit(10)
                    ->get();
        });

        // Router summary progress
        Route::controller(BusinessProgressController::class)->prefix('progress')->group(function() {
            Route::get('/admin', 'businessAdmin');
            Route::get('/mentee', 'businessMentee');
            Route::post('/create', 'store');
            Route::get('/export-csv', 'exportCsv');
            Route::get('/{id}', 'show');
        });

        // Fungsi cari owner di edit company
        Route::get('/search/owners', [CompanyController::class, 'searchOwners']);

        Route::controller(CompanyController::class)->group(function() {
            Route::get('/company', 'index');
            Route::get('/detail/company/{id}', 'show');
            Route::put('/update/company/{id}', 'update');
            Route::post('/create/company', 'store');
            Route::delete('/delete/company/{id}', 'destroy');
        });

        Route::controller(KelasController::class)->group(function() {
            Route::get('/kelas', 'index');
            Route::get('/detail/kelas/{id}', 'show');
            Route::put('/update/kelas/{id}', 'update');
            Route::post('/create/kelas', 'store');
            Route::delete('/delete/kelas', 'destroy');
        });

        Route::controller(MentorController::class)->group(function() {
            Route::get('/mentor', 'index');
            Route::get('/detail/mentor', 'show');
            Route::post('/create/mentor', 'store');
        });
    });

    // Group untuk role: mentee
    Route::middleware('role:mentee')->group(function() {

        // Router company untuk mentee
        Route::controller(CompanyController::class)->group(function() {
            Route::get('/company', 'index');
            Route::get('/detail/company/{id}', 'show');
            Route::put('/update/company/{id}', 'update');
            Route::post('/create/company', 'store');
            Route::delete('/delete/company/{id}', 'destroy');
        });

        // Router absensi
        Route::controller(AttendanceController::class)->group(function() {
            Route::get('/absen', 'index');
            Route::get('/history/absen', 'historyAbsen');
            Route::get('/absen/{id}', 'show');
            Route::post('/create/absen', 'store');
        });

        // Router mutabaah mentee
        Route::controller(MutabahReportController::class)->group(function() {
            Route::get('/mutabaah', 'index');
            Route::get('/mutabaah/mentee', 'mentee');
            Route::get('/detail/mutabaah/{id}', 'show');
            Route::put('/update/mutabaah/{id}', 'update');
            Route::post('/create/mutabaah', 'store');
            Route::delete('/delete/mutabaah/{id}', 'destroy');
            Route::get('/mutabaah/export', 'exportCSV')->name('mutabaah.export');
        });

        // Router profile mentee
        Route::controller(MenteeProfileController::class)->group(function() {
            Route::get('/profile-mente', 'profile');
            Route::post('/create/menteprofile', 'store');
        });

    });

});
