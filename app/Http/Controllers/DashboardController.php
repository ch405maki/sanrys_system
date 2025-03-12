<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Document;
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

        return Inertia::render('Dashboard/Index', [
            'weeklyAttendanceData' => $weeklyAttendanceData,
            'recentEmployees' => $recentEmployees,
            'complianceData' => $complianceData
        ]);
    }

    // Helper function to calculate weekly attendance performance
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
                'week' => "Week " . (5 - $i), // Corrected to dynamically label weeks
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
            ]);
        }

        return $weeklyData;
    }
}
