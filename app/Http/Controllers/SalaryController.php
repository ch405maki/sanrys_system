<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Salary;
use App\Models\Deduction;

class SalaryController extends Controller
{
    public function index()
    {
        $users = User::has('salary')->with('salary')->get();
        $usersWithoutSalary = User::doesntHave('salary')->get();
    
        return inertia('Salary/Index', [
            'users' => $users,
            'usersWithoutSalary' => $usersWithoutSalary
        ]);
    }

    public function salary()
    {
        $user = User::with(['deductions', 'profile', 'salary'])->find(Auth::id());
    
        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'User not found.');
        }
    
        return inertia('Salary/MySalary', ['user' => $user]);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rate_per_day' => 'required|numeric|min:0',
            'overtime_rate' => 'required|numeric|min:0',
            'holiday_rate' => 'required|numeric|min:0',
            'allowance' => 'required|numeric|min:0',
            'monthly_rate' => 'required|numeric|min:0'
        ]);

        Salary::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'rate_per_day' => $request->rate_per_day,
                'overtime_rate' => $request->overtime_rate,
                'holiday_rate' => $request->holiday_rate,
                'allowance' => $request->allowance,
                'monthly_rate' => $request->monthly_rate
            ]
        );

        return response()->json(['message' => 'Salary details saved successfully!']);
    }
}
