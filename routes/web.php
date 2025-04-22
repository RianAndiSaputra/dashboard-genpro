<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

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
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');
    
    // Admin, Mentor, Secretary, KepalaSekolah Routes
    Route::middleware(['role:admin,mentor,secretary,kepalaSekolah'])->group(function () {
        Route::get('/formulir', function () {
            return view('mente.formulir');
        })->name('formulir');
        
        Route::get('/daftar-compeny', function () {
            return view('dashboard.daftar-compeny');
        })->name('daftar-compeny');
        
        Route::get('/Summary-Financial', function () {
            return view('dashboard.Summary-Financial');
        })->name('summary-financial');
        
        Route::get('/finance-report', function () {
            return view('dashboard.finance-report');
        })->name('finance-report');
        
        Route::get('/mutabaah', function () {
            return view('dashboard.mutabaah');
        })->name('mutabaah');
        
        Route::get('/daftar-kelas', function () {
            return view('dashboard.daftar-kelas');
        })->name('daftar-kelas');
    });
    
    // Routes for Mentee role
    Route::middleware(['role:mentee'])->group(function () {
        Route::get('/kelas-mente', function () {
            return view('mente.kelas');
        })->name('kelas-mente');
        
        Route::get('/mutabaah-mente', function () {
            return view('mente.mutabaah');
        })->name('mutabaah-mente');
        
        Route::get('/profile-mente', function () {
            return view('mente.profile');
        })->name('profile-mente');
        
        Route::get('/absen', function () {
            return view('mente.absen');
        })->name('absen');
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
