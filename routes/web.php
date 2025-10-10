<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceCorrectionController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\ApprovalController;

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

    // Route::get('/employee', function () {
    //     return view('employee');

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee')->middleware('role:employee');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('companies', CompanyController::class);
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('companies', CompanyController::class);
// });

// Route::middleware(['auth', 'role:employee'])->group(function () {
//     Route::get('/employees/absensi', [AbsensiController::class, 'index'])
//         ->name('employees.absensi');
//     Route::get('/employees/absensi/create', [AbsensiController::class, 'create'])
//         ->name('employees.absensi_create');
//     Route::post('/employees/absensi', [AbsensiController::class, 'store'])
//     ->name('employees.absensi_store');

// });




// Halaman absensi utama
Route::get('/employees/absensi', [AbsensiController::class, 'index'])->name('employees.absensi');

// Form manual create (opsional, bisa dipakai atau dihapus)
Route::get('/employees/absensi/create', [AbsensiController::class, 'create'])->name('employees.absensi_create');

// Proses Check-in
Route::post('/employees/absensi/checkin', [AbsensiController::class, 'checkIn'])->name('employees.checkin');

// Proses Check-out
Route::post('/employees/absensi/checkout', [AbsensiController::class, 'checkOut'])->name('employees.checkout');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');


Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');



Route::get('/document', [DocumentController::class, 'index'])->name('document.index');

Route::middleware('auth')->group(function () {
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/cuti/create', [LeaveController::class, 'createCuti'])->name('leave.cuti.create');
    Route::get('/leave/izin-sakit/create', [LeaveController::class, 'createIzinSakit'])->name('leave.izin_sakit.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
});



Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::post('/approvals/{id}', [ApprovalController::class, 'update'])->name('admin.approvals.update');
});


require __DIR__.'/auth.php';
