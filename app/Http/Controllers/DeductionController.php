<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    // Display the deduction management page
    public function index()
    {
        $users = User::has('deductions')->with('deductions')->get();
        $usersWithoutDeductions = User::doesntHave('deductions')->get();
    
        return inertia('Contributions/Index', [
            'users' => $users,
            'usersWithoutDeductions' => $usersWithoutDeductions
        ]);
    }

    // Store or update deduction
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pag_ibig' => 'required|numeric|min:0',
            'sss' => 'required|numeric|min:0',
            'philhealth' => 'required|numeric|min:0',
            'maxicare' => 'required|numeric|min:0',
        ]);

        Deduction::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'pag_ibig' => $request->pag_ibig,
                'sss' => $request->sss,
                'philhealth' => $request->philhealth,
                'maxicare' => $request->maxicare,
            ]
        );

        return redirect()->back()->with('success', 'Deductions successfully saved!');
    }
}
