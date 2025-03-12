<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GovernmentBenefit;

class GovernmentBenefitController extends Controller
{
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sss_no' => 'nullable|string|max:20',
            'pag_ibig_no' => 'nullable|string|max:20',
            'philhealth_no' => 'nullable|string|max:20',
            'tin_no' => 'nullable|string|max:20',
            'employee_no' => 'nullable|string|max:20',
            'date_employed' => 'nullable|date',
        ]);

        return GovernmentBenefit::create($request->all());
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
