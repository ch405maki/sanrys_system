<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Document;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Weekly Attendance Performance
        $weeklyAttendanceData = $this->getWeeklyAttendance();

        // Recent Employees
        $recentEmployees = User::with('profile')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'position' => $user->profile?->position ?? 'N/A',
                    'status' => $user->status ?? 'Inactive',
                ];
            });

        // Compliance Data (Submitted, Pending, Overdue)
        $complianceData = [
            'submitted' => Document::where('status', 'Submitted')->count(),
            'pending' => Document::where('status', 'Pending')->count(),
            'overdue' => Document::where('status', 'Overdue')->count(),
        ];

        // Get the authenticated user
        $user = auth()->user();

        // Get the user's daily attendance status
        $dailyAttendanceStatus = $this->getDailyAttendanceStatus($user);

        // Get the daily attendance summary for all users
        $dailyAttendanceSummary = $this->getDailyAttendanceSummary();

        return Inertia::render('Dashboard/Index', [
            'weeklyAttendanceData' => $weeklyAttendanceData,
            'recentEmployees' => $recentEmployees,
            'complianceData' => $complianceData,
            'user' => $user,
            'dailyAttendanceStatus' => $dailyAttendanceStatus,
            'dailyAttendanceSummary' => $dailyAttendanceSummary, // Pass summary to Vue
        ]);
    }

    /**
     * Get the daily attendance status for the authenticated user.
     *
     * @param \App\Models\User $user
     * @return array
     */
    private function getDailyAttendanceStatus($user)
    {
        // Get today's date
        $today = Carbon::today()->toDateString();

        // Fetch the user's schedule for today
        $schedule = Schedule::where('user_id', $user->id)
            ->where('day_of_week', strtolower(Carbon::now()->englishDayOfWeek)) // Match day of week
            ->first();

        // If no schedule exists for today, return 'absent'
        if (!$schedule) {
            return [
                'status' => 'absent',
                'message' => 'No schedule found for today.',
            ];
        }

        // Fetch today's attendance record
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('time_in', $today)
            ->first();

        // If no attendance record, mark as absent
        if (!$attendance) {
            return [
                'status' => 'absent',
                'message' => 'No attendance record found for today.',
            ];
        }

        // Compare time_in with schedule start_time
        $startTime = Carbon::parse($schedule->start_time);
        $timeIn = Carbon::parse($attendance->time_in);

        if ($timeIn->gt($startTime)) {
            return [
                'status' => 'late',
                'message' => 'You were late today.',
            ];
        }

        return [
            'status' => 'on_time',
            'message' => 'You were on time today.',
        ];
    }

    /**
     * Get the daily attendance summary for all users.
     *
     * @return array
     */
    /**
 * Get the daily attendance summary for all users.
 *
 * @return array
 */
private function getDailyAttendanceSummary()
{
    $today = Carbon::today()->toDateString();
    $dayOfWeek = strtolower(Carbon::now()->englishDayOfWeek); // Get current day of the week

    $onTime = 0;
    $late = 0;
    $absent = 0;

    // Fetch all users with their schedules and today's attendance
    $users = User::with(['schedules' => function ($query) use ($dayOfWeek) {
        $query->where('day_of_week', $dayOfWeek); // Filter schedules for the current day
    }, 'attendances' => function ($query) use ($today) {
        $query->whereDate('time_in', $today); // Filter attendance for today
    }])->get();

    foreach ($users as $user) {
        $schedule = $user->schedules->first(); // Get the schedule for the current day
        $attendance = $user->attendances->first(); // Get today's attendance record

        // If no schedule exists for today, mark as absent
        if (!$schedule) {
            $absent++;
            continue;
        }

        // If no attendance record, mark as absent
        if (!$attendance) {
            $absent++;
            continue;
        }

        // Compare time_in with schedule start_time
        $timeIn = Carbon::parse($attendance->time_in);
        $startTime = Carbon::parse($schedule->start_time);

        if ($timeIn->gt($startTime)) {
            $late++;
        } else {
            $onTime++;
        }
    }

    return [
        'on_time' => $onTime,
        'late' => $late,
        'absent' => $absent,
    ];
}

    /**
     * Calculate weekly attendance performance.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getWeeklyAttendance()
    {
        $now = Carbon::now();

        $weeklyData = collect();

        for ($i = 4; $i >= 0; $i--) {
            $startOfWeek = $now->copy()->subWeeks($i)->startOfWeek()->toDateString();
            $endOfWeek = $now->copy()->subWeeks($i)->endOfWeek()->toDateString();

            $present = Attendance::whereBetween('time_in', [$startOfWeek, $endOfWeek])->count();
            $absent = User::count() - $present; // Assuming total users - present = absent
            $late = Attendance::whereBetween('time_in', [$startOfWeek, $endOfWeek])
                ->whereRaw("TIME(time_in) > '08:00:00'") // Example late rule
                ->count();

            $weeklyData->push([
                'week' => "Week " . (5 - $i),
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
            ]);
        }

        return $weeklyData;
    }
}