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
            <div class="grid grid-cols-1 gap-4 mt-8 sm:grid-cols-3 px-2">
                <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                    <div class="p-4 bg-green-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg></div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Total Staff</h3>
                        <p class="text-3xl">{{totalUsers}}</p>
                    </div>
                </div>
                <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                    <div class="p-4 bg-blue-400">
                        <svg class="h-12 w-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Today's Attendance</h3>
                        <p class="text-3xl">{{ totalAttendanceToday }}</p>
                    </div>
                </div>
                <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                    <div class="p-4 bg-purple-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                            </path>
                        </svg></div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Total Documents</h3>
                        <p class="text-3xl">{{ totalDocuments }}</p>
                    </div>
                </div>
            </div>

            <!-- Daily Attendance Summary Bar Chart -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Daily Attendance Summary</h3>
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
                        <a :href="route('documents.index')" class="text-green-600 hover:text-green-700 hover:underline">All Documents</a>
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
    complianceData: Object, 
    totalUsers: Number, 
    totalAttendanceToday: Number,
    totalDocuments: Number, 
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