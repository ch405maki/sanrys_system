<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Profile;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $users = User::with(['profile', 'attendances'])->get();
    
        return Inertia::render('Attendance/Index', [
            'users' => $users,
        ]);
    }


    public function show($id)
    {
        $user = User::with(['profile', 'attendances'])->find($id);
        
        return Inertia::render('Attendance/Show', [
            'user' => $user,
        ]);
    }

    public function create()
    {
        $currentUserId = auth()->id();
        $attendance = Attendance::where('user_id', $currentUserId)->get();
        $user = User::with(['profile'])->find($currentUserId);

        return Inertia::render('Time/Index', [
            'userId' => $currentUserId,
            'attendances' => $attendance,
            'user' => $user,
        ]);
    }
    // Handle time-in
    public function timeIn(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if the user has already timed in today
        $existingAttendance = Attendance::where('user_id', $request->user_id)
            ->whereDate('time_in', Carbon::today())
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'You have already timed in today.'], 400);
        }

        // Create a new attendance record
        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'time_in' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Time-in recorded successfully!', 'attendance' => $attendance], 201);
    }

    // Handle time-out
    public function timeOut(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Find the latest attendance record for the user
        $attendance = Attendance::where('user_id', $request->user_id)
            ->whereDate('time_in', Carbon::today())
            ->whereNull('time_out')
            ->latest()
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'No time-in record found for today.'], 400);
        }

        // Update the time-out
        $attendance->update([
            'time_out' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Time-out recorded successfully!', 'attendance' => $attendance], 200);
    }

    public function hasTimedInToday(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $hasTimedIn = Attendance::where('user_id', $request->user_id)
            ->whereDate('time_in', Carbon::today())
            ->exists();

        return response()->json(['has_timed_in' => $hasTimedIn], 200);
    }

    public function update(Request $request, $id)
    {
        // Find the attendance record by ID
        $attendance = Attendance::find($id);

        // If the record doesn't exist, return a 404 error
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

        // Update the record
        $attendance->update([
            'time_in' => $request->input('time_in'),
            'time_out' => $request->input('time_out'),
        ]);

        // Return a success response
        return response()->json(['message' => 'Attendance updated successfully']);
    }
}   