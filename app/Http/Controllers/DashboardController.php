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

        // Compliance Data (Counts)
        $complianceData = [
            'submitted' => Document::where('status', 'Submitted')->count(),
            'pending' => Document::where('status', 'Pending')->count(),
            'overdue' => Document::where('status', 'Overdue')->count(),
        ];

        // Total Users
        $totalUsers = User::count();

        // Total Attendance for Today
        $totalAttendanceToday = Attendance::whereDate('time_in', Carbon::today()->toDateString())->count();

        // Total Documents
        $totalDocuments = Document::count();

        $documents = Document::all();

        // Get the authenticated user
        $user = auth()->user();

        // Get the user's daily attendance status
        $dailyAttendanceStatus = $this->getDailyAttendanceStatus($user);

        // Get attendance data for the last 7 days
        $startDate = Carbon::today()->subDays(6)->toDateString(); // Last 7 days including today
        $endDate = Carbon::today()->toDateString();
        $attendanceDataForDateRange = $this->getAttendanceDataForDateRange($startDate, $endDate);

        return Inertia::render('Dashboard/Index', [
            'weeklyAttendanceData' => $weeklyAttendanceData,
            'recentEmployees' => $recentEmployees,
            'complianceData' => $complianceData,
            'totalUsers' => $totalUsers,
            'totalAttendanceToday' => $totalAttendanceToday,
            'totalDocuments' => $totalDocuments,
            'user' => $user,
            'documents' => $documents,
            'dailyAttendanceStatus' => $dailyAttendanceStatus,
            'attendanceDataForDateRange' => $attendanceDataForDateRange,
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

    /**
     * Get attendance data for a range of dates.
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    private function getAttendanceDataForDateRange($startDate, $endDate)
    {
        $attendanceData = [];

        $dates = Carbon::parse($startDate)->toPeriod($endDate);

        foreach ($dates as $date) {
            $dateString = $date->toDateString();
            $dayOfWeek = strtolower($date->englishDayOfWeek);

            $onTime = 0;
            $late = 0;
            $absent = 0;

            // Fetch all users with their schedules and attendance for the given date
            $users = User::with(['schedules' => function ($query) use ($dayOfWeek) {
                $query->where('day_of_week', $dayOfWeek);
            }, 'attendances' => function ($query) use ($dateString) {
                $query->whereDate('time_in', $dateString);
            }])->get();

            foreach ($users as $user) {
                $schedule = $user->schedules->first();
                $attendance = $user->attendances->first();

                if (!$schedule) {
                    $absent++;
                    continue;
                }

                if (!$attendance) {
                    $absent++;
                    continue;
                }

                $timeIn = Carbon::parse($attendance->time_in);
                $startTime = Carbon::parse($schedule->start_time);

                if ($timeIn->gt($startTime)) {
                    $late++;
                } else {
                    $onTime++;
                }
            }

            $attendanceData[$dateString] = [
                'on_time' => $onTime,
                'late' => $late,
                'absent' => $absent,
            ];
        }

        return $attendanceData;
    }
}