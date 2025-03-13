<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\EducationalBackgroundController;
use App\Http\Controllers\PreviousEmploymentRecordController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\GovernmentBenefitController;

Route::get('/user/profile', [ProfileController::class, 'getProfile'])->middleware('auth');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Employee routes
Route::post('/employees', [EmployeeController::class, 'store']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
Route::put('//employees/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::put('/employees/{id}/status', [EmployeeController::class, 'updateStatus']);


// Attendance routes
Route::post('/attendances/time-in', [AttendanceController::class, 'timeIn']);
Route::post('/attendances/time-out', [AttendanceController::class, 'timeOut']);
Route::post('/attendances/has-timed-in-today', [AttendanceController::class, 'hasTimedInToday']);
Route::put('/attendances/{id}', [AttendanceController::class, 'update']);

// Payroll routes
Route::post('/payroll/generate/{userId}', [PayrollController::class, 'generatePayroll']);
Route::post('/payroll/generate-all', [PayrollController::class, 'generatePayrollForAll']);


// Document upload routes
Route::post('/documents/upload', [DocumentController::class, 'upload']);
Route::get('/users/{userId}/documents', [DocumentController::class, 'index']);
Route::put('/documents/{documentId}/status', [DocumentController::class, 'updateStatus']);
Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);

// Deduction
Route::post('/deductions/store', [DeductionController::class, 'store'])->name('deductions.store');
Route::put('/deductions/{id}', [DeductionController::class, 'update']); 
Route::delete('/deductions/{id}', [DeductionController::class, 'destroy']); 

// Salary
Route::post('/salaries/store', [SalaryController::class, 'store'])->name('salaries.store'); 
Route::put('/salaries/{id}', [SalaryController::class, 'update']);
Route::delete('/salaries/{id}', [SalaryController::class, 'destroy']);


// Personal Info
// Skills
Route::get('/skills', [SkillController::class, 'index']); // Get all skills
Route::post('/skills', [SkillController::class, 'store']); // Store a new skill

// Educational
Route::get('/educations', [EducationalBackgroundController::class, 'index']);
Route::post('/educations', [EducationalBackgroundController::class, 'store']);
Route::get('/educations/{id}', [EducationalBackgroundController::class, 'show']);
Route::put('/educations/{id}', [EducationalBackgroundController::class, 'update']);
Route::delete('/educations/{id}', [EducationalBackgroundController::class, 'destroy']);

Route::prefix('employment-records')->group(function () {
    Route::get('/', [PreviousEmploymentRecordController::class, 'index']);
    Route::post('/', [PreviousEmploymentRecordController::class, 'store']);
    Route::get('/{id}', [PreviousEmploymentRecordController::class, 'show']);
    Route::put('/{id}', [PreviousEmploymentRecordController::class, 'update']);
    Route::delete('/{id}', [PreviousEmploymentRecordController::class, 'destroy']);
});

Route::apiResource('references', ReferenceController::class);
Route::apiResource('emergency-contacts', EmergencyContactController::class);
Route::apiResource('government-benefits', GovernmentBenefitController::class);
