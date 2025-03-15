<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\EducationalBackground;
use App\Models\PreviousEmploymentRecord;
use App\Models\Reference;
use App\Models\EmergencyContact;
use App\Models\GovernmentBenefit;


use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::has('profile')
            ->with('profile')
            ->whereHas('profile', function ($query) {
                $query->where('status', '!=', 'resigned');
            })
            ->get();
    
        return Inertia::render('Employees/Index', ['employees' => $employees]);
    }

    public function archive()
    {
        $employees = User::has('profile')
            ->with('profile')
            ->whereHas('profile', function ($query) {
                $query->where('status', 'resigned');
            })
            ->get();
    
        return Inertia::render('Employees/Archive', ['employees' => $employees]);
    }

    // Start of Store
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|max:255',
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

            // Skills
            'skills' => 'nullable|array',
            'skills.*.skill_name' => 'nullable|string|max:255',
            'skills.*.proficiency_level' => 'nullable|string|max:255',
            'skills.*.description' => 'nullable|string',

            // Educational Background
            'educational_background' => 'nullable|array',
            'educational_background.college' => 'nullable|string|max:255',
            'educational_background.college_course' => 'nullable|string|max:255',
            'educational_background.college_school_year' => 'nullable|string|max:255',
            'educational_background.secondary' => 'nullable|string|max:255',
            'educational_background.secondary_course' => 'nullable|string|max:255',
            'educational_background.secondary_school_year' => 'nullable|string|max:255',
            'educational_background.elementary' => 'nullable|string|max:255',
            'educational_background.elementary_course' => 'nullable|string|max:255',
            'educational_background.elementary_school_year' => 'nullable|string|max:255',

            // Previous Employment Records
            'previous_employment_records' => 'nullable|array',
            'previous_employment_records.*.company_name' => 'required|string|max:255',
            'previous_employment_records.*.position' => 'required|string|max:255',
            'previous_employment_records.*.date_employed' => 'required|date',
            'previous_employment_records.*.salary' => 'required|numeric',
            'previous_employment_records.*.reason_of_leaving' => 'required|string|max:255',

            // References
            'references' => 'nullable|array',
            'references.*.name' => 'required|string|max:255',
            'references.*.contact' => 'required|string|max:20',
            'references.*.occupation' => 'required|string|max:255',
            'references.*.relation' => 'required|string|max:255',

            // Emergency Contacts
            'emergency_contacts' => 'nullable|array',
            'emergency_contacts.*.name' => 'required|string|max:255',
            'emergency_contacts.*.address' => 'required|string|max:255',
            'emergency_contacts.*.contact' => 'required|string|max:20',
            'emergency_contacts.*.relation' => 'required|string|max:255',

            // Government Benefits
            'government_benefits' => 'nullable|array',
            'government_benefits.sss_no' => 'nullable|string|max:255',
            'government_benefits.pag_ibig_no' => 'nullable|string|max:255',
            'government_benefits.philhealth_no' => 'nullable|string|max:255',
            'government_benefits.tin_no' => 'nullable|string|max:255',
            'government_benefits.employee_no' => 'nullable|string|max:255',
            'government_benefits.date_employed' => 'nullable|date',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
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

        // Store Skills
        if ($request->has('skills')) {
            foreach ($request->skills as $skill) {
                $user->skills()->create([
                    'skill_name' => $skill['skill_name'],
                    'proficiency_level' => $skill['proficiency_level'],
                    'description' => $skill['description'],
                ]);
            }
        }
        
        // Store Educational Background
        if ($request->has('educational_background')) {
            $user->educationalBackground()->create($request->educational_background);
        }

        // Store Previous Employment Records
        if ($request->has('previous_employment_records')) {
            foreach ($request->previous_employment_records as $record) {
                $user->previousEmploymentRecords()->create($record);
            }
        }

        // Store References
        if ($request->has('references')) {
            foreach ($request->references as $reference) {
                $user->references()->create($reference);
            }
        }

        // Store Emergency Contacts
        if ($request->has('emergency_contacts')) {
            foreach ($request->emergency_contacts as $contact) {
                $user->emergencyContacts()->create($contact);
            }
        }

        // Store Government Benefits
        if ($request->has('government_benefits')) {
            $user->governmentBenefits()->create($request->government_benefits);
        }

        // Return a success response
        return response()->json(['message' => 'Employee created successfully!'], 201);
    }

    // End of Store

    public function updateStatus(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'status' => 'required', // Ensure the status is valid
        ]);
    
        // Find the user (employee)
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        // Update the status
        $user->status = $request->status;
        $user->save();
    
        return response()->json(['message' => 'User status updated successfully'], 200);
    }


    public function show($id)
    {
        // Fetch the employee with all related data
        $employee = User::with([
            'profile',
            'skills',
            'educationalBackground',
            'previousEmploymentRecords',
            'references',
            'emergencyContacts',
            'governmentBenefits'
        ])->find($id);

        if (!$employee) {
            return redirect()->route('employee.index')->with('error', 'Employee not found.');
        }

        return Inertia::render('Employees/Show', [
            'employee' => $employee
        ]);
    }

    public function edit($id)
    {
        $employee = User::with([
            'profile',
            'skills',
            'educationalBackground',
            'previousEmploymentRecords',
            'references',
            'emergencyContacts',
            'governmentBenefits'
        ])->find($id);

        if (!$employee) {
            return redirect()->route('employee.index')->with('error', 'Employee not found.');
        }

        return Inertia::render('Employees/Edit', [
            'employee' => $employee
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = User::with([
            'profile',
            'skills',
            'educationalBackground',
            'previousEmploymentRecords',
            'references',
            'emergencyContacts',
            'governmentBenefits'
        ])->find($id);

        if (!$employee) {
            return redirect()->route('employee.index')->with('error', 'Employee not found.');
        }

        // Validate request data
        $request->validate([
            // User details
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'role' => 'required|string|max:255',

            // Profile details
            'position' => 'required|string',
            'branch' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
            'age' => 'nullable|integer',
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

            // Skills
            'skills' => 'nullable|array',
            'skills.*.skill_name' => 'required|string|max:255',
            'skills.*.proficiency_level' => 'nullable|string|max:255',
            'skills.*.description' => 'nullable|string',

            // Educational Background
            'educational_background' => 'nullable|array',
            'educational_background.college' => 'nullable|string|max:255',
            'educational_background.college_course' => 'nullable|string|max:255',
            'educational_background.college_school_year' => 'nullable|string|max:255',
            'educational_background.secondary' => 'nullable|string|max:255',
            'educational_background.secondary_course' => 'nullable|string|max:255',
            'educational_background.secondary_school_year' => 'nullable|string|max:255',
            'educational_background.elementary' => 'nullable|string|max:255',
            'educational_background.elementary_course' => 'nullable|string|max:255',
            'educational_background.elementary_school_year' => 'nullable|string|max:255',

            // Previous Employment Records
            'previous_employment_records' => 'nullable|array',
            'previous_employment_records.*.company_name' => 'required|string|max:255',
            'previous_employment_records.*.position' => 'required|string|max:255',
            'previous_employment_records.*.date_employed' => 'required|date',
            'previous_employment_records.*.salary' => 'required|numeric',
            'previous_employment_records.*.reason_of_leaving' => 'required|string|max:255',

            // References
            'references' => 'nullable|array',
            'references.*.name' => 'required|string|max:255',
            'references.*.contact' => 'required|string|max:20',
            'references.*.occupation' => 'required|string|max:255',
            'references.*.relation' => 'required|string|max:255',

            // Emergency Contacts
            'emergency_contacts' => 'nullable|array',
            'emergency_contacts.*.name' => 'required|string|max:255',
            'emergency_contacts.*.address' => 'required|string|max:255',
            'emergency_contacts.*.contact' => 'required|string|max:20',
            'emergency_contacts.*.relation' => 'required|string|max:255',

            // Government Benefits
            'government_benefits' => 'nullable|array',
            'government_benefits.sss_no' => 'nullable|string|max:255',
            'government_benefits.pag_ibig_no' => 'nullable|string|max:255',
            'government_benefits.philhealth_no' => 'nullable|string|max:255',
            'government_benefits.tin_no' => 'nullable|string|max:255',
            'government_benefits.employee_no' => 'nullable|string|max:255',
            'government_benefits.date_employed' => 'nullable|date',
        ]);

        // Update employee details
        $employee->update($request->only('name', 'email', 'role'));

        // Update profile details
        $employee->profile->update($request->only([
            'position', 'branch', 'contact_number', 'age', 'sex', 'civil_status',
            'citizenship', 'religion', 'weight', 'height', 'date_of_birth',
            'place_of_birth', 'present_address', 'permanent_address'
        ]));

        // Update skills
        if ($request->has('skills')) {
            $employee->skills()->delete(); // Delete existing skills
            foreach ($request->skills as $skill) {
                $employee->skills()->create($skill);
            }
        }

        // Update educational background
        if ($request->has('educational_background')) {
            $employee->educationalBackground()->updateOrCreate(
                ['user_id' => $employee->id],
                $request->educational_background
            );
        }

        // Update previous employment records
        if ($request->has('previous_employment_records')) {
            $employee->previousEmploymentRecords()->delete(); // Delete existing records
            foreach ($request->previous_employment_records as $record) {
                $employee->previousEmploymentRecords()->create($record);
            }
        }

        // Update references
        if ($request->has('references')) {
            $employee->references()->delete(); // Delete existing references
            foreach ($request->references as $reference) {
                $employee->references()->create($reference);
            }
        }

        // Update emergency contacts
        if ($request->has('emergency_contacts')) {
            $employee->emergencyContacts()->delete(); // Delete existing contacts
            foreach ($request->emergency_contacts as $contact) {
                $employee->emergencyContacts()->create($contact);
            }
        }

        // Update government benefits
        if ($request->has('government_benefits')) {
            $employee->governmentBenefits()->updateOrCreate(
                ['user_id' => $employee->id],
                $request->government_benefits
            );
        }

        return redirect()->route('employee.show', $employee->id)->with('success', 'Employee updated successfully!');
    }
    
    public function destroy($id)
    {
        $employee = User::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}