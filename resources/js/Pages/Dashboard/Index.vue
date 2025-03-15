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
            <!-- Charts Section -->
            <!-- Weekly Attendance Performance Chart -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Weekly Attendance Performance Chart</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <canvas ref="attendanceChartCanvas" class="h-[150px]"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Recent Employees Table -->
                <div class="md:col-span-2 p-4 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-8">Recent Employees</h3>
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
                <!-- Compliance Submission Chart -->
                <div class="p-4 bg-white rounded-lg ">
                    <h3 class="text-lg font-semibold text-gray-800 mb-8">Compliance</h3>
                    <canvas ref="complianceChartCanvas" class="h-[300px]"></canvas>
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
    user: Object
});

const statusClass = (status) => {
    return {
        'bg-green-500': status === 'active',
        'bg-yellow-500': status === 'pending',
        'bg-red-500': status === 'inactive',
        'bg-gray-400': !['active', 'pending', 'inactive'].includes(status)
    };
};


// Attendance Chart
const attendanceChartCanvas = ref(null);

// Compliance Chart
const complianceChartCanvas = ref(null);

onMounted(() => {
    // Attendance Chart
    const ctxAttendance = attendanceChartCanvas.value.getContext('2d');
    new Chart(ctxAttendance, {
        type: 'line',
        data: {
            labels: props.weeklyAttendanceData.map(data => data.week),
            datasets: [
                {
                    label: 'Present',
                    data: props.weeklyAttendanceData.map(data => data.present),
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                    fill: true,
                },
                {
                    label: 'Absent',
                    data: props.weeklyAttendanceData.map(data => data.absent),
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                    fill: true,
                },
                {
                    label: 'Late',
                    data: props.weeklyAttendanceData.map(data => data.late),
                    backgroundColor: 'rgba(234, 179, 8, 0.2)',
                    borderColor: 'rgba(234, 179, 8, 1)',
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(234, 179, 8, 1)',
                    fill: true,
                }
            ]
        }
    });

    // Compliance Chart
    const ctxCompliance = complianceChartCanvas.value.getContext('2d');
    new Chart(ctxCompliance, {
        type: 'polarArea',
        data: {
            labels: ['Submitted'],
            datasets: [
                {
                    data: [
                        props.complianceData.submitted,
                    ],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.5)', // Green  
                    ],
                    borderWidth: 1
                }
            ]
        }
    });
});
</script>