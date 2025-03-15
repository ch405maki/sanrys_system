<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        // Fetch all users with their schedules
        $users = User::with('schedules')->get();

        // Pass users as props to the Inertia view
        return Inertia::render('Schedule/Index', [
            'users' => $users,
        ]);
    }

    // Store a new schedule for a user
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedules' => 'required|array',
            'schedules.*.day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i|after:schedules.*.start_time',
        ]);

        // Create schedules
        foreach ($request->schedules as $schedule) {
            Schedule::create([
                'user_id' => $request->user_id,
                'day_of_week' => $schedule['day_of_week'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
            ]);
        }

        return response()->json([
            'message' => 'Schedules assigned successfully!',
        ]);
    }

    // Get all schedules for a user
    public function show($userId)
    {
        // Find the user
        $user = User::findOrFail($userId);

        // Get the user's schedules
        $schedules = $user->schedules;

        return response()->json([
            'message' => 'Schedules retrieved successfully!',
            'schedules' => $schedules,
        ]);
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}