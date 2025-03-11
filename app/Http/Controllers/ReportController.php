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
        $month = $request->input('month', now()->format('Y-m')); // Default to current month
        $cutOffPeriod = $request->input('cut_off_period'); // Ensure this matches the Vue request

        // Convert month to Carbon object
        $date = Carbon::createFromFormat('Y-m', $month);

        // Query Payroll data
        $query = Payroll::with('user')
            ->whereYear('pay_period_start', $date->year)
            ->whereMonth('pay_period_start', $date->month);

        if (!empty($cutOffPeriod)) {
            $query->where('cut_off_period', $cutOffPeriod);
        }

        $payrolls = $query->orderBy('pay_period_end', 'desc')->get();

        // Pass data to Vue
        return Inertia::render('Reports/PayrollReport', [
            'payrolls' => $payrolls,
            'selectedMonth' => $month,
            'selectedCutOff' => $cutOffPeriod
        ]);
    }

}
