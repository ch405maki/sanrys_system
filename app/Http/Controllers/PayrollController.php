<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function generatePayroll(Request $request, $userId)
    {
        // Validate the request
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $user = User::findOrFail($userId);

        // Example data (can be stored in database in the future)
        $ratePerDay = 500;   // Employee's daily rate
        $overtimeRate = 50;  // Per hour
        $holidayRate = 2;    // Double pay on holidays
        $allowance = 200;    // Fixed allowance
        $deduction = 100;    // Example deduction

        // Fetch attendance records within the pay period
        $attendances = $user->attendances()
            ->whereBetween('time_in', [$startDate, $endDate])
            ->get();

        $totalWorkdays = $attendances->count();
        $totalOvertime = 0;
        $totalHolidayPay = 0;

        // Define public holidays
        $holidays = ['2025-02-25', '2025-04-09']; // Add more dates

        foreach ($attendances as $attendance) {
            $timeIn = Carbon::parse($attendance->time_in);
            $timeOut = Carbon::parse($attendance->time_out);
            $workDate = $timeIn->toDateString();

            $workHours = $timeIn->diffInHours($timeOut);
            
            // Check if the work date is a holiday
            if (in_array($workDate, $holidays)) {
                $totalHolidayPay += $ratePerDay * $holidayRate;
            }

            // Calculate overtime (if worked more than 8 hours)
            if ($workHours > 8) {
                $totalOvertime += ($workHours - 8);
            }
        }

        // Compute payroll amounts
        $basicSalary = $totalWorkdays * $ratePerDay;
        $overtimePay = $totalOvertime * $overtimeRate;
        $grossPay = $basicSalary + $overtimePay + $totalHolidayPay + $allowance;
        $netPay = $grossPay - $deduction;

        // Store Payroll Data
        Payroll::create([
            'user_id' => $user->id,
            'rate_per_day' => $ratePerDay,
            'basic_salary' => $basicSalary,
            'overtime_pay' => $overtimePay,
            'holiday_pay' => $totalHolidayPay,
            'allowance' => $allowance,
            'deductions' => $deduction,
            'gross_pay' => $grossPay,
            'net_pay' => $netPay,
            'pay_period_start' => $startDate,
            'pay_period_end' => $endDate,
        ]);

        // Return the payroll details along with total workdays
        return response()->json([
            'message' => 'Payroll generated successfully!',
            'total_workdays' => $totalWorkdays,
            'basic_salary' => $basicSalary,
            'overtime_pay' => $overtimePay,
            'holiday_pay' => $totalHolidayPay,
            'allowance' => $allowance,
            'gross_pay' => $grossPay,
            'net_pay' => $netPay,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
