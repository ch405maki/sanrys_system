<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'skill_name' => 'required|string|max:255',
            'proficiency_level' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the skill using user_id from request
        $skill = Skill::create([
            'user_id' => $request->user_id, // Use user_id from the request
            'skill_name' => $request->skill_name,
            'proficiency_level' => $request->proficiency_level,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Skill created successfully!',
            'skill' => $skill,
        ], 201);
    }



    /**
     * Get all skills for the authenticated user.
     */
    public function index()
    {
        $skills = Skill::where('user_id', Auth::id())->get();
        return response()->json($skills);
    }
}