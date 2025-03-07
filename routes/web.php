<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;

use App\Models\Attendance;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

// employee
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');

    Route::get('/employee/create', function () {
        return Inertia::render('Employees/Create');
    })->name('employee.create');
});

// time
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/time', [AttendanceController::class, 'create'])->name('time.index');
});

// attendance
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/show/{id}', [AttendanceController::class, 'show'])->name('attendance.show');
});

// payroll
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/payroll', function () {
        return Inertia::render('Payroll/Index');
    })->name('payroll.index');

    Route::get('/payslip', [PayrollController::class, 'payslip'])->name('payroll.payslip');
    Route::get('/filter-payslip', [PayrollController::class, 'filterPayslip']);
});

// contributions
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contributions', function () {
        return Inertia::render('Contributions/Index');
    })->name('contributions.index');
});

// documents
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/documents', function () {
        return Inertia::render('Documents/Index');
    })->name('documents.index');

    Route::get('/documents/mydocs', function () {
        return Inertia::render('Documents/MyDocs');
    })->name('documents.mydocs');
});

// compliance
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/compliance', function () {
        return Inertia::render('Compliance/Index');
    })->name('compliance.index');

    Route::get('/compliance/show', function () {
        return Inertia::render('Compliance/MyCompliance');
    })->name('compliance.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
})->name('/logout');

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

require __DIR__.'/auth.php';
