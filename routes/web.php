<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

// Auth Routes
Route::get('/', function () {
    // Jika sudah login, redirect ke dashboard
    if (Auth::guard('sanctum')->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Dashboard Route (protected)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Fallback route untuk invalid URLs
Route::fallback(function () {
    return redirect()->route('login');
});
  

    // Tambahkan route protected lainnya di sini


// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// });

route::get('/daftar-compeny', function () {
    return view('dashboard.daftar-compeny');
});
Route::get('/Summary-Financial', function () {
    return view('dashboard.Summary-Financial');
});
Route::get('/finance-report', function () {
    return view('dashboard.finance-report');
});
Route::get('/absen', function () {
    return view('mente.absen');
});
Route::get('/formulir', function () {
    return view('mente.formulir');
});

Route::get('/mutabaah', function () {
    return view('dashboard.mutabaah');
});

Route::get('/daftar-kelas', function () {
    return view('dashboard.daftar-kelas');
});


Route::get('/profile-mente', function () {
    return view('mente.profile');
});

Route::get('/kelas-mente', function () {
    return view('mente.kelas');
});

Route::get('/mutabaah-mente', function () {
    return view('mente.mutabaah');
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
