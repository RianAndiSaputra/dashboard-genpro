<?php

// use App\Models\User;
// use App\Models\Mentor;
// use App\Models\Company;
// use Illuminate\Http\Request;
// use App\Models\MenteeProfile;
// use App\Models\MutabaahReport;
// use App\Http\Controllers\MutabaahReportController;
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



// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){

    Route::middleware('role:admin,kepalaSekolah, ')->group(function(){

        // Route::controller(MenteeProfileController::class)->group(function () {
        //     Route::get('/menteprofile', 'index');
        //     Route::post('/create/menteprofile', 'store');
        // });

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

        Route::controller(KelasController::class)->group(function(){
            Route::get('/kelas', 'index');
            Route::get('/detail/kelas/{id}', 'show');
            Route::put('/update/kelas/{id}', 'update');
            Route::post('/create/kelas', 'store');
            Route::delete('/delete/kelas', 'destroy');
        });

        Route::controller(MentorController::class)->group(function (){
            Route::get('/mentor', 'index');
            Route::get('/detail/mentor', 'show');
            Route::post('/create/mentor', 'store');
            // Route::put('/mentor', 'index');
        });
    });

    Route::middleware('role:mentee')->group(function(){

        Route::controller(CompanyController::class)->group(function(){
            Route::get('/company', 'index');
            Route::get('/detail/company/{id}', 'show');
            Route::put('/update/company/{id}', 'update');
            Route::post('/create/company', 'store');
            Route::delete('/delete/company/{id}', 'destroy');
        });
    
        Route::controller(MutabahReportController::class)->group(function() {
            Route::get('/mutabaah', 'index');
            Route::get('/detail/mutabaah/{id}', 'show');
            Route::put('/update/mutabaah/{id}', 'update');
            Route::post('/create/mutabaah', 'store');
            Route::delete('/delete/mutabaah', 'destroy');
        });
    
        Route::controller(BusinessFinancialController::class)->prefix('financial')->group(function (){
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create','store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    
        Route::controller(AttendanceController::class)->group(function(){
            Route::get('/absen', 'index');
            Route::get('/detail/absen/{id}', 'show');
            Route::post('/create/absen', 'store');
        });
    
        Route::controller(BusinessProgressContoller::class)->group(function(){
        
        });

    });

});