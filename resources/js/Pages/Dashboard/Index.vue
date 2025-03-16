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

            <!-- Daily Attendance Summary Bar Chart -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Daily Attendance Summary (Last 7 Days)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <canvas ref="dailyAttendanceChartCanvas" class="h-[150px]"></canvas>
                </div>
            </div>

            <!-- Recent Employees Table -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 p-4 bg-white rounded-lg">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 mb-8">Recent Employees</h3>
                        <h3 class="text-lg font-semibold text-gray-800 mb-8">Status</h3>
                    </div>
                    <div 
                        v-for="employee in recentEmployees" 
                        :key="employee.id"
                        class="flex justify-between items-center border-b py-2"
                    >
                        <div>
                            <p class="font-medium text-sm text-gray-800">{{ employee.name }}</p>
                            <p class="text-xs text-gray-500">{{ employee.position }}</p>
                        </div>
                        <div>
                            <span 
                                class="py-1 px-4 rounded-full text-xs font-medium text-white uppercase"
                                :class="statusClass(employee.status)"
                            >
                                {{ employee.status }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 p-4 bg-white rounded-lg">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 mb-8">Compliance</h3>
                        <a href="" class="text-green-600 hover:text-green-700 hover:underline">All Documents</a>
                    </div>
                    <div 
                        v-for="document in documents" 
                        :key="document.id"
                        class="flex justify-between items-center border-b py-2"
                    >
                        <div>
                            <p class="font-medium text-sm text-gray-800">{{ document.document_name }}</p>
                            <p class="text-xs text-gray-500">{{ document.description }}</p>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
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
    documents: Object,
    user: Object,
    dailyAttendanceStatus: Object,
    attendanceDataForDateRange: Object,
});

// Define the statusClass function
const statusClass = (status) => {
    return {
        'bg-green-500': status === 'active',
        'bg-yellow-500': status === 'pending',
        'bg-red-500': status === 'inactive',
        'bg-gray-400': !['active', 'pending', 'inactive'].includes(status),
    };
};

// Bar Chart for Daily Attendance Summary
const dailyAttendanceChartCanvas = ref(null);

onMounted(() => {
    const labels = Object.keys(props.attendanceDataForDateRange);
    const onTimeData = labels.map(date => props.attendanceDataForDateRange[date].on_time);
    const lateData = labels.map(date => props.attendanceDataForDateRange[date].late);
    const absentData = labels.map(date => props.attendanceDataForDateRange[date].absent);

    // Daily Attendance Summary Bar Chart
    const ctxDailyAttendance = dailyAttendanceChartCanvas.value.getContext('2d');
    new Chart(ctxDailyAttendance, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'On Time',
                    data: onTimeData,
                    backgroundColor: 'rgba(34, 197, 94, 0.5)', // Green for On Time
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Late',
                    data: lateData,
                    backgroundColor: 'rgba(234, 179, 8, 0.5)', // Yellow for Late
                    borderColor: 'rgba(234, 179, 8, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Absent',
                    data: absentData,
                    backgroundColor: 'rgba(239, 68, 68, 0.5)', // Red for Absent
                    borderColor: 'rgba(239, 68, 68, 1)',
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
});
</script>