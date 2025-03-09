<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}
