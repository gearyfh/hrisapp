<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceCorrectionController;
use App\Http\Controllers\OvertimeRequestController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\NotificationController;

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
    Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('role:admin');
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee')->middleware('role:employee');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('companies', CompanyController::class);
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('companies', CompanyController::class);
// });
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


Route::middleware('auth')->group(function () {
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/cuti/create', [LeaveController::class, 'createCuti'])->name('leave.cuti.create');
    // Route::get('/leave/izin-sakit/create', [LeaveController::class, 'createIzinSakit'])->name('leave.izin_sakit.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave/detail/{id}', [LeaveController::class, 'detail'])->name('leave.detail');
});

Route::middleware('auth')->group(function () {
    Route::get('/sick', [LeaveController::class, 'indexSick'])->name('sick.index');
    Route::get('/sick/izin-sakit/create', [LeaveController::class, 'createIzinSakit'])->name('sick.createsick');
    Route::post('/sick', [LeaveController::class, 'store'])->name('sick.store');
    Route::get('/sick/detail/{id}', [LeaveController::class, 'detailSick'])->name('sick.detail');

});



// Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
//     Route::get('/approvals', [ApprovalController::class, 'index'])->name('admin.approvals.index');
//     Route::post('/approvals/{id}', [ApprovalController::class, 'update'])->name('admin.approvals.update');
    
//     Route::post('/approvals/{id}/approve', [ApprovalController::class, 'approve'])->name('admin.approvals.approve');
//     Route::post('/approvals/{id}/reject', [ApprovalController::class, 'reject'])->name('admin.approvals.reject');   
// });

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Halaman utama approvals
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('admin.approvals.index');

    // Halaman khusus pengajuan CUTI
    Route::get('/approvals/cuti', [ApprovalController::class, 'cuti'])->name('admin.approvals.cuti');
    Route::get('/approvals/cuti/{id}', [ApprovalController::class, 'showCuti'])->name('admin.approvals.cuti.show');

    // Halaman khusus pengajuan IZIN / SAKIT
    Route::get('/approvals/izin-sakit', [ApprovalController::class, 'izinSakit'])->name('admin.approvals.izin_sakit');
    Route::get('/approvals/izin-sakit/{id}', [ApprovalController::class, 'showIzinSakit'])->name('admin.approvals.izin_sakit.show');

    // Update status
    Route::post('/approvals/{id}/update', [ApprovalController::class, 'update'])->name('admin.approvals.update');
    Route::post('/approvals/{id}/approve', [ApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/approvals/{id}/reject', [ApprovalController::class, 'reject'])->name('admin.approvals.reject');

    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('admin.documents.index');
    Route::get('/documents/create', [AdminDocumentController::class, 'create'])->name('admin.documents.create');
    Route::post('/documents', [AdminDocumentController::class, 'store'])->name('admin.documents.store');

});

// Halaman absensi utama
Route::middleware(['auth', 'role:employee'])->prefix('admin')->group(function () {
    Route::get('/employees/absensi', [AbsensiController::class, 'index'])->name('employees.attendance.absensi');
    // Form manual create (opsional, bisa dipakai atau dihapus)
    Route::get('/employees/absensi/create', [AbsensiController::class, 'create'])->name('employees.attendance.absensi_create');
    // Proses Check-in
    Route::post('/employees/absensi/checkin', [AbsensiController::class, 'checkIn'])->name('employees.checkin');
    // Proses Check-out
    Route::post('/employees/absensi/checkout', [AbsensiController::class, 'checkOut'])->name('employees.checkout');
    Route::get('/employees/documents/{id}', [EmployeeController::class, 'show_document'])->name('employees.show_documents');
});

// --- Employee ---
Route::middleware(['auth', 'role:employee'])->prefix('employee')->group(function () {
    Route::get('/corrections', [AttendanceCorrectionController::class, 'myCorrections'])->name('employees.corrections.index');
    Route::get('/corrections/select', [AttendanceCorrectionController::class, 'selectAttendance'])->name('employees.corrections.select');
    Route::get('/corrections/create/{attendance_id}', [AttendanceCorrectionController::class, 'create'])->name('employees.corrections.create');
    Route::post('/corrections', [AttendanceCorrectionController::class, 'store'])->name('employees.corrections.store');
    Route::get('/corrections/{id}', [AttendanceCorrectionController::class, 'show'])->name('employees.corrections.show');

});

// --- Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/corrections', [ApprovalController::class, 'correctionIndex'])->name('admin.corrections.index');
    Route::get('/corrections/{id}', [ApprovalController::class, 'correctionShow'])->name('admin.corrections.show');
    Route::post('/corrections/{id}/update', [ApprovalController::class, 'correctionUpdate'])->name('admin.corrections.update');
});


Route::middleware(['auth', 'role:employee'])->prefix('employee')->group(function () {
    Route::get('/overtimes', [OvertimeRequestController::class, 'index'])->name('employees.overtime.index');
    Route::get('/overtimes/select', [OvertimeRequestController::class, 'selectAttendance'])->name('employees.overtime.select');
    Route::get('/overtimes/create/{attendance_id}', [OvertimeRequestController::class, 'create'])->name('employees.overtime.create');
    Route::post('/overtimes', [OvertimeRequestController::class, 'store'])->name('employees.overtime.store');
});

Route::middleware(['auth', 'role:employee'])->prefix('employee')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/approvals/overtimes', [ApprovalController::class, 'overtimeIndex'])->name('admin.overtime.index');
    Route::get('/approvals/overtimes/{id}', [ApprovalController::class, 'overtimeShow'])->name('admin.overtime.show');
    Route::post('/approvals/overtimes/{id}', [ApprovalController::class, 'overtimeUpdate'])->name('admin.overtimes.update');
});






require __DIR__.'/auth.php';
