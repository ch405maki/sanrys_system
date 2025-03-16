<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Hi, <span class="text-xl font-semibold text-green-800">{{ user.name }}</span>
                </h2>
                <div>
                    <span class="text-xl font-normal text-green-800">/Dashboard</span>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <!-- Daily Attendance Status -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Daily Attendance Status</h3>
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="text-lg font-medium">
                        Status: 
                        <span :class="{
                            'text-green-600': dailyAttendanceStatus.status === 'on_time',
                            'text-yellow-600': dailyAttendanceStatus.status === 'late',
                            'text-red-600': dailyAttendanceStatus.status === 'absent',
                        }">
                            {{ dailyAttendanceStatus.message }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Daily Attendance Summary Bar Chart -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Daily Attendance Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <canvas ref="dailyAttendanceChartCanvas" class="h-[150px]"></canvas>
                </div>
            </div>

            <!-- Rest of your code -->
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
    weeklyAttendanceData: Array,
    recentEmployees: Array,
    complianceData: Object,
    user: Object,
    dailyAttendanceStatus: Object,
    dailyAttendanceSummary: Object, // Add dailyAttendanceSummary to props
});

// Bar Chart for Daily Attendance Summary
const dailyAttendanceChartCanvas = ref(null);

onMounted(() => {
    // Daily Attendance Summary Bar Chart
    const ctxDailyAttendance = dailyAttendanceChartCanvas.value.getContext('2d');
    new Chart(ctxDailyAttendance, {
        type: 'bar',
        data: {
            labels: ['On Time', 'Late', 'Absent'],
            datasets: [
                {
                    label: 'Number of Users',
                    data: [
                        props.dailyAttendanceSummary.on_time,
                        props.dailyAttendanceSummary.late,
                        props.dailyAttendanceSummary.absent,
                    ],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.5)', // Green for On Time
                        'rgba(234, 179, 8, 0.5)', // Yellow for Late
                        'rgba(239, 68, 68, 0.5)', // Red for Absent
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    // Rest of your chart initialization code
});
</script>