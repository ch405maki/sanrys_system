<?php

namespace App\Http\Controllers;

use App\Models\PreviousEmploymentRecord;
use Illuminate\Http\Request;

class PreviousEmploymentRecordController extends Controller
{
    public function index()
    {
        return response()->json(PreviousEmploymentRecord::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'date_employed' => 'required|date',
            'salary' => 'required|numeric',
            'reason_of_leaving' => 'nullable|string',
        ]);

        $record = PreviousEmploymentRecord::create($request->all());

        return response()->json([
            'message' => 'Previous employment record created successfully!',
            'record' => $record
        ], 201);
    }

    public function show($id)
    {
        $record = PreviousEmploymentRecord::findOrFail($id);
        return response()->json($record, 200);
    }

    public function update(Request $request, $id)
    {
        $record = PreviousEmploymentRecord::findOrFail($id);
        $record->update($request->all());

        return response()->json([
            'message' => 'Previous employment record updated successfully!',
            'record' => $record
        ], 200);
    }

    public function destroy($id)
    {
        $record = PreviousEmploymentRecord::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
