<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use Inertia\Inertia;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Employee Payroll Summary Report
    public function employeePayrollSummary(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m')); // Default: Current month
        $cutOffPeriod = $request->input('cut_off_period');        // Optional filter

        // Filter Payroll data
        $query = Payroll::with('user')
            ->whereYear('pay_period_start', Carbon::parse($month)->year)
            ->whereMonth('pay_period_start', Carbon::parse($month)->month);

        if ($cutOffPeriod) {
            $query->where('cut_off_period', $cutOffPeriod);
        }

        $payrolls = $query->orderBy('pay_period_end', 'desc')->get();

        // Pass data to the Vue component
        return Inertia::render('Reports/PayrollReport', [
            'payrolls' => $payrolls,
            'selectedMonth' => $month,
            'selectedCutOff' => $cutOffPeriod
        ]);
    }
}
