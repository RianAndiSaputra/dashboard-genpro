<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenteeProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BusinessProgressController;
use App\Http\Controllers\MutabahReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\KelasController;

// Auth Routes (Public)
    Route::get('/', function () {
      // Redirect to dashboard if already logged in
        if (Auth::guard('sanctum')->check()) {
         return redirect()->route('dashboard');
        }
         return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

    // Dashboard Routes - Protected by Authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        // Common route for all authenticated users
        Route::get('/dashboard', [MenteeProfileController::class, 'indexdashboard'])->name('dashboard');
    // Admin, Mentor, Secretary, KepalaSekolah Routes
    Route::middleware(['role:admin,mentor,secretary,kepalaSekolah'])->group(function () {
           Route::view('/formulir', 'mente.formulir')->name('formulir');
        
    // Registrasi mentee (store User + Profile)
        Route::get('/formulir', 'App\Http\Controllers\MenteeProfileController@showFormulir')->name('formulir');
    
    // Route untuk CRUD mentee
        Route::post('/mentee', [MenteeProfileController::class, 'store'])->name('mentee.store');
        Route::get('/mentee/{id}', [MenteeProfileController::class, 'show'])->name('mentee.show');
        Route::put('/mentee/{id}', [MenteeProfileController::class, 'update'])->name('mentee.update');
        Route::delete('/mentee/{id}', [MenteeProfileController::class, 'destroy'])->name('mentee.destroy');
    
    // Route untuk registrasi mentee (akan membuat user juga)
        Route::post('/register-mentee', [AuthController::class, 'register'])->name('mentee.register');
        
        Route::get('/daftar-compeny', function () {
            return view('dashboard.daftar-compeny');
        })->name('daftar-compeny');

        //router summary admin
        Route::get('/Summary-financial-admin', [BusinessProgressController::class,  'businessAdmin'])->name('summary-financial-admin');
        
        // router mutabah
        Route::get('/mutabaah-admin', [MutabahReportController::class, 'index']);
        //router daftar kelas
        Route::get('/daftar-kelas', [KelasController::class, 'index'])->middleware(['auth:sanctum', 'role:admin,mentor,secretary,kepalaSekolah']);
        Route::post('/kelas', 'App\Http\Controllers\KelasController@store')->name('kelas.store');
        Route::get('/kelas/{id}', 'App\Http\Controllers\KelasController@show')->name('kelas.show');
        Route::put('/kelas/{id}', 'App\Http\Controllers\KelasController@update')->name('kelas.update');
        Route::delete('/kelas/{id}', 'App\Http\Controllers\KelasController@destroy')->name('kelas.destroy');
        Route::post('/kelas/tambah-peserta', [KelasController::class, 'tambahPeserta'])->name('kelas.tambah-peserta');

        // routes/web.php
        Route::get('/kelas/{kelas}/peserta', [KelasController::class, 'getPeserta']);
        Route::put('/mentee/{mentee}/status', [KelasController::class, 'updateStatus']);

        Route::post('/kelas/tambah-peserta', [KelasController::class, 'tambahPeserta']);
        Route::get('/kelas/{kelas}/peserta', [KelasController::class, 'getPeserta']);
        Route::put('/mentee/{mentee}/status', [KelasController::class, 'updateStatus']);

        Route::post('/mentee-profile/update/{id}', [MenteeProfileController::class, 'updatePeserta']);
        Route::delete('/mentee-profile/delete/{id}', [MenteeProfileController::class, 'deletePeserta']);

        // Mentee routes
        Route::get('/mentee/{id}', [KelasController::class, 'getMentee']);
        Route::put('/mentee/{id}/update', [KelasController::class, 'updateMentee']);
        Route::delete('/mentee/{id}', [KelasController::class, 'destroyMentee']);
        // Route::get('/Summary-Financial', function () {
        //     return view('dashboard.Summary-Financial');
        // })->name('summary-financial');
        
        // Route::get('/finance-report', function () {
        //     return view('dashboard.finance-report');
        // })->name('finance-report');
        
        // Route::get('/mutabaah', function () {
        //     return view('dashboard.mutabaah');
        // })->name('mutabaah');
        
        // Route::get('/daftar-kelas', function () {
        //     return view('dashboard.daftar-kelas');
        // })->name('daftar-kelas');
    });
    
    // Routes for Mentee role
    Route::middleware(['role:mentee'])->group(function () {
      
        //router untuk profile saya
        // Route::middleware(['role:mentee'])->group(function () {
            Route::get('/profile-mente', [MenteeProfileController::class, 'profile'])->name('mente.profile-mente');
            Route::put('/profile-mente/update', [MenteeProfileController::class, 'updateProfile'])->name('mente.profile-mente.update');
        // });
        // Route::get('/profile-mente', [MenteeProfileController::class, 'profile'])->name('mente.profile-mente');
        // Route::put('/profile-mente/update/{id}', [MenteeProfileController::class, 'updateProfile'])->name('mente.profile-mente.update');
        // Route::get('/test-view', function() {
        //     $user = Auth::user(); // Pastikan user login
        //     $mentee = MenteeProfile::where('user_id', $user->id)->first();
        //     return view('mente.profile-mente', compact('mentee'));
        // });

        // router untu summary mente
        Route::get('/summary-financial-mentee', [BusinessProgressController::class, 'businessMentee'])->name('summary-financial');    
        //router untuk mutabaah
        Route::get('/mentee-mutabaah', [MutabahReportController::class,  'mentee'])->name('mutabaah-mentee');
        //router untuk absen
        Route::get('/absen', [AttendanceController::class,  'index']);

        
        Route::get('/kelas-mente', function () {
            return view('mente.kelas');
        })->name('kelas-mente');
        
        //     Route::get('/mutabaah-mente', function () {
        //     return view('mente.mutabaah');
        // })->name('mutabaah-mente');
        
        // // Route::get('/profile-mente', function () {
        // //     return view('mente.profile');
        // // })->name('profile-mente');
        
        // Route::get('/absen', function () {
        //     return view('mente.absen');
        // })->name('absen');
    });
});

// Fallback route for invalid URLs
Route::fallback(function () {
    return redirect()->route('login');
});
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
