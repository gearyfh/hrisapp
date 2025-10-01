<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role == 'superadmin') {
            return redirect('/superadmin');
        } elseif ($role == 'admin') {
            return redirect('/admin');
        } else {
            return redirect('/employee');
        }
    });

    Route::get('/superadmin', function () {
        return view('superadmin');
    })->middleware('role:superadmin');

    Route::get('/admin', function () {
        return view('admin');
    })->middleware('role:admin');

    Route::get('/employee', function () {
        return view('employee');
    })->middleware('role:employee');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('companies', CompanyController::class);
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('companies', CompanyController::class);
// });

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employees/absensi', [AbsensiController::class, 'index'])
        ->name('employees.absensi');
    Route::get('/employees/absensi/create', [AbsensiController::class, 'create'])
        ->name('employees.absensi_create');
    Route::post('/employees/absensi', [AbsensiController::class, 'store'])
    ->name('employees.absensi_store');

});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

require __DIR__.'/auth.php';
