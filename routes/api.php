<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/employees', [EmployeeController::class, 'store']);

Route::post('/attendances/time-in', [AttendanceController::class, 'timeIn']);
Route::post('/attendances/time-out', [AttendanceController::class, 'timeOut']);
Route::post('/attendances/has-timed-in-today', [AttendanceController::class, 'hasTimedInToday']);

Route::post('/payroll/generate/{userId}', [PayrollController::class, 'generatePayroll']);
