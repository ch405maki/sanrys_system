<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

use App\Models\Attendance;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// employee
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/archive', [EmployeeController::class, 'archive'])->name('employee.archive');
    Route::get('/employee/create', function () { return Inertia::render('Employees/Create');})->name('employee.create');

    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employee.update');

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
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/report', [PayrollController::class, 'report'])->name('payroll.report');
    
    Route::get('/payslip', [PayrollController::class, 'payslip'])->name('payroll.payslip');
    Route::get('/filter-payslip', [PayrollController::class, 'filterPayslip']);
});

// contributions
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contributions', [DeductionController::class, 'index'])->name('contributions.index');      
});

// salary
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/salary', [SalaryController::class, 'index'])->name('salary.index');      
    Route::get('/salary/show', [SalaryController::class, 'salary'])->name('deductions.show');      

});


// documents
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/mydocs', [DocumentController::class, 'mydoc'])->name('documents.mydocs');
    Route::get('/documents/show/{user}', [DocumentController::class, 'show'])->name('documents.show');
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

// reports
Route::get('/reports/payroll', [ReportController::class, 'employeePayrollSummary'])
    ->name('reports.payroll');



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
