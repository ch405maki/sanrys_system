<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payroll;
use App\Models\Salary;
use App\Models\Deduction;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index (){
        $users = User::with('profile')->get();
        return Inertia::render('Payroll/Index',['users' => $users ]);
    }

    public function report(){
        
        $users = User::has('payrolls')->with('payrolls')->get();

        return Inertia::render('Payroll/Report',['users' => $users ]);
    }

    // Generate all user payrolls
    public function generatePayrollForAll(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $cutOffPeriod = $this->getCutOffPeriod($startDate, $endDate);

        // Fetch users with their attendances, salary, and deductions
        $users = User::with(['attendances', 'salary', 'deduction'])->get();
        $payrollDetails = [];

        foreach ($users as $user) {
            $totalWorkdays = $user->attendances()
                ->whereBetween('time_in', [$startDate, $endDate])
                ->count();

            $ratePerDay = $user->salary?->rate_per_day ?? 0;
            $allowance = $user->salary?->allowance ?? 0;
            $monthlyRate = $user->salary?->monthly_rate ?? 0;

            // Calculate basic salary and gross pay
            $basicSalary = $totalWorkdays * $ratePerDay;
            $grossPay = $basicSalary + $allowance;

            // Fetch deductions for the user
            $deductions = $user->deduction ?? null;
            $totalDeductions = $deductions ? ($deductions->pag_ibig + $deductions->sss + $deductions->philhealth + $deductions->maxicare) : 0;

            // Calculate net pay
            $netPay = $grossPay - $totalDeductions;

            // Create payroll record
            Payroll::create([
                'user_id' => $user->id,
                'rate_per_day' => $ratePerDay,
                'basic_salary' => $basicSalary,
                'allowance' => $allowance,
                'monthly_rate' => $monthlyRate,
                'gross_pay' => $grossPay,
                'net_pay' => $netPay,
                'pay_period_start' => $startDate,
                'pay_period_end' => $endDate,
                'total_workdays' => $totalWorkdays,
                'cut_off_period' => $cutOffPeriod,
                'deductions' => $totalDeductions, // Save total deductions
            ]);

            $payrollDetails[] = [
                'user' => $user->name,
                'total_workdays' => $totalWorkdays,
                'basic_salary' => $basicSalary,
                'allowance' => $allowance,
                'monthly_rate' => $monthlyRate,
                'gross_pay' => $grossPay,
                'net_pay' => $netPay,
                'cut_off_period' => $cutOffPeriod,
                'deductions' => $totalDeductions, // Include deductions in response
            ];
        }

        return response()->json([
            'message' => 'Payroll generated for all users successfully!',
            'payrollDetails' => $payrollDetails,
        ]);
    }

    // generate single user payroll
    public function generatePayroll(Request $request, $userId)
    {
        // Validate the request
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Determine the cut-off period
        $cutOffPeriod = $this->getCutOffPeriod($startDate, $endDate);

        // Fetch the user with their attendances, salary, and deductions
        $user = User::with(['attendances', 'salary', 'deduction'])->findOrFail($userId);

        // Fetch attendance records within the pay period
        $attendances = $user->attendances()
            ->whereBetween('time_in', [$startDate, $endDate])
            ->get();

        // Calculate total workdays
        $totalWorkdays = $attendances->count();

        // Get salary details from the user's salary record
        $ratePerDay = $user->salary?->rate_per_day ?? 0;
        $allowance = $user->salary?->allowance ?? 0;
        $monthlyRate = $user->salary?->monthly_rate ?? 0;

        // Calculate overtime and holiday pay
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
                $totalHolidayPay += $ratePerDay * 2; // Double pay on holidays
            }

            // Calculate overtime (if worked more than 8 hours)
            if ($workHours > 8) {
                $totalOvertime += ($workHours - 8);
            }
        }

        // Compute payroll amounts
        $basicSalary = $totalWorkdays * $ratePerDay;
        $overtimePay = $totalOvertime * ($user->salary?->overtime_rate ?? 50); // Default overtime rate
        $grossPay = $basicSalary + $overtimePay + $totalHolidayPay + $allowance;

        // Fetch deductions for the user
        $deductions = $user->deduction ?? null;
        $totalDeductions = $deductions ? ($deductions->pag_ibig + $deductions->sss + $deductions->philhealth + $deductions->maxicare) : 0;

        // Calculate net pay
        $netPay = $grossPay - $totalDeductions;

        // Store Payroll Data
        Payroll::create([
            'user_id' => $user->id,
            'rate_per_day' => $ratePerDay,
            'basic_salary' => $basicSalary,
            'overtime_pay' => $overtimePay,
            'holiday_pay' => $totalHolidayPay,
            'allowance' => $allowance,
            'deductions' => $totalDeductions, // Save total deductions
            'gross_pay' => $grossPay,
            'net_pay' => $netPay,
            'pay_period_start' => $startDate,
            'pay_period_end' => $endDate,
            'cut_off_period' => $cutOffPeriod,
            'total_workdays' => $totalWorkdays,
        ]);

        // Return the payroll details
        return response()->json([
            'message' => 'Payroll generated successfully!',
            'total_workdays' => $totalWorkdays,
            'basic_salary' => $basicSalary,
            'overtime_pay' => $overtimePay,
            'holiday_pay' => $totalHolidayPay,
            'allowance' => $allowance,
            'gross_pay' => $grossPay,
            'net_pay' => $netPay,
            'cut_off_period' => $cutOffPeriod,
            'deductions' => $totalDeductions, // Include deductions in response
        ]);
    }

    private function getCutOffPeriod($startDate, $endDate)
    {
        $startDay = Carbon::parse($startDate)->day;
        $endDay = Carbon::parse($endDate)->day;

        if ($startDay >= 1 && $endDay <= 15) {
            return '1-15';
        } else {
            return '16-' . Carbon::parse($endDate)->endOfMonth()->day;
        }
    }

    public function filterPayslip(Request $request)
    {
        // Get the current user's ID
        $userId = auth()->id();

        // Fetch the user's data, including their profile
        $user = User::with('profile')->find($userId);

        $cutOffPeriod = $request->input('cut_off_period');
        $month = $request->input('month'); // Format: YYYY-MM

        $query = Payroll::where('user_id', $user->id);

        if ($cutOffPeriod) {
            $query->where('cut_off_period', $cutOffPeriod);
        }

        if ($month) {
            $monthStart = Carbon::parse($month)->startOfMonth()->toDateString();
            $monthEnd = Carbon::parse($month)->endOfMonth()->toDateString();

            $query->where(function ($q) use ($monthStart, $monthEnd) {
                $q->whereBetween('pay_period_start', [$monthStart, $monthEnd])
                ->orWhereBetween('pay_period_end', [$monthStart, $monthEnd]);
            });
        }

        $payroll = $query->orderBy('created_at', 'desc')->first();

        return Inertia::render('Payroll/Payslip', [
            'payroll' => $payroll,
            'user' => $user,
            'total_workdays' => $payroll ? $payroll->total_workdays : null, // Pass total_workdays
        ]);
    }

    public function payslip(Request $request)
    {
        // Get the current user's ID
        $userId = auth()->id();

        // Fetch the user's data, including their profile
        $user = User::with('profile', 'deduction')->find($userId);

        // Fetch the latest payroll record for the user
        $payroll = Payroll::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return Inertia::render('Payroll/Payslip', [
            'payroll' => $payroll, // Pass payroll data to Vue
            'user' => $user, // Pass user details with profile
            'total_workdays' => $payroll ? $payroll->total_workdays : null, // Pass total_workdays
        ]);
    }
}
