<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
    Route::get('/employee', function () {
        return Inertia::render('Employees/Index');
    })->name('employee.index');

    Route::get('/employee/create', function () {
        return Inertia::render('Employees/Create');
    })->name('employee.create');
});

// time
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/time', function () {
        return Inertia::render('Time/Index');
    })->name('time.index');
});

// attendance
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/attendance', function () {
        return Inertia::render('Attendance/Index');
    })->name('attendance.index');

    Route::get('/attendance/show', function () {
        return Inertia::render('Attendance/Show');
    })->name('attendance.show');
});

// payroll
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/payroll', function () {
        return Inertia::render('Payroll/Index');
    })->name('payroll.index');
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
