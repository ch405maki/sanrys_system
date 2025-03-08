<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;

Route::get('/user/profile', [ProfileController::class, 'getProfile'])->middleware('auth');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Employee routes
Route::post('/employees', [EmployeeController::class, 'store']);

// Attendance routes
Route::post('/attendances/time-in', [AttendanceController::class, 'timeIn']);
Route::post('/attendances/time-out', [AttendanceController::class, 'timeOut']);
Route::post('/attendances/has-timed-in-today', [AttendanceController::class, 'hasTimedInToday']);

// Payroll routes
Route::post('/payroll/generate/{userId}', [PayrollController::class, 'generatePayroll']);
Route::post('/payroll/generate-all', [PayrollController::class, 'generatePayrollForAll']);


// Document upload routes
Route::post('/documents/upload', [DocumentController::class, 'upload']); // Upload a document
Route::get('/users/{userId}/documents', [DocumentController::class, 'index']); // Get all documents for a user
Route::put('/documents/{documentId}/status', [DocumentController::class, 'updateStatus']); // Update document status
Route::delete('/documents/{documentId}', [DocumentController::class, 'destroy']); // Delete a document
