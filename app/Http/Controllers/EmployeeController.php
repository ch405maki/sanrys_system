<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Profile;

use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::has('profile')->with('profile')->get();
    
        return Inertia::render('Employees/Index', [ 'employees' => $employees ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'age' => 'nullable|integer',
            'position' => 'required|string',
            'branch' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
            'sex' => 'nullable|string|in:Male,Female,Other',
            'civil_status' => 'nullable|string|in:Single,Married,Divorced,Widowed',
            'citizenship' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create the profile
        $user->profile()->create([
            'position' => $request->position,
            'branch' => $request->branch,
            'age' => $request->age,
            'contact_number' => $request->contact_number,
            'sex' => $request->sex,
            'civil_status' => $request->civil_status,
            'citizenship' => $request->citizenship,
            'religion' => $request->religion,
            'weight' => $request->weight,
            'height' => $request->height,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'present_address' => $request->present_address,
            'permanent_address' => $request->permanent_address,
            'profile_picture' => $profilePicturePath,
        ]);

        // Return a success response
        return response()->json(['message' => 'Employee created successfully!'], 201);
    }
}