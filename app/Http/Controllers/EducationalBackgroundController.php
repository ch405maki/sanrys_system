<?php

namespace App\Http\Controllers;

use App\Models\EducationalBackground;
use Illuminate\Http\Request;

class EducationalBackgroundController extends Controller
{
    // Get all educational backgrounds
    public function index()
    {
        return response()->json(EducationalBackground::with('user')->get());
    }

    // Store educational background
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'college' => 'nullable|string|max:255',
            'college_course' => 'nullable|string|max:255',
            'college_school_year' => 'nullable|string|max:255',
            'secondary' => 'nullable|string|max:255',
            'secondary_course' => 'nullable|string|max:255',
            'secondary_school_year' => 'nullable|string|max:255',
            'elementary' => 'nullable|string|max:255',
            'elementary_course' => 'nullable|string|max:255',
            'elementary_school_year' => 'nullable|string|max:255',
        ]);

        $education = EducationalBackground::create($request->all());

        return response()->json(['message' => 'Educational Background saved successfully!', 'data' => $education], 201);
    }

    // Show a specific educational background
    public function show($id)
    {
        $education = EducationalBackground::with('user')->findOrFail($id);
        return response()->json($education);
    }

    // Update educational background
    public function update(Request $request, $id)
    {
        $education = EducationalBackground::findOrFail($id);

        $request->validate([
            'college' => 'nullable|string|max:255',
            'college_course' => 'nullable|string|max:255',
            'college_school_year' => 'nullable|string|max:255',
            'secondary' => 'nullable|string|max:255',
            'secondary_course' => 'nullable|string|max:255',
            'secondary_school_year' => 'nullable|string|max:255',
            'elementary' => 'nullable|string|max:255',
            'elementary_course' => 'nullable|string|max:255',
            'elementary_school_year' => 'nullable|string|max:255',
        ]);

        $education->update($request->all());

        return response()->json(['message' => 'Educational Background updated successfully!', 'data' => $education]);
    }

    // Delete educational background
    public function destroy($id)
    {
        $education = EducationalBackground::findOrFail($id);
        $education->delete();

        return response()->json(['message' => 'Educational Background deleted successfully!']);
    }
}
