<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Hi, <span class="text-xl font-semibold text-green-800">Administrator</span>
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
                    <canvas ref="attendanceChartCanvas" class="h-[300px]"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Recent Employees Table -->
                <div class="md:col-span-2 p-4 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-8">Recent Employees</h3>
                    <div 
                        v-for="employee in recentEmployees" 
                        :key="employee.id"
                        class="flex justify-between border-b py-2"
                    >
                        <div>
                            <p class="font-medium text-sm text-gray-800">{{ employee.name }}</p>
                            <p class="text-xs text-gray-500">{{ employee.position }}</p>
                        </div>
                        <div>
                            <span :class="statusClass(employee.status)" class="py-1 px-3 rounded-full text-xs">
                                {{ employee.status }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Compliance Submission Chart -->
                <div class="p-4 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Compliance</h3>
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

// Attendance Chart
const attendanceChartCanvas = ref(null);

// Compliance Chart
const complianceChartCanvas = ref(null);

// Sample Recent Employees
const recentEmployees = ref([
    { id: 1, name: 'Juan Dela Cruz', position: 'Software Engineer', status: 'Active' },
    { id: 2, name: 'Maria Santos', position: 'HR Manager', status: 'On Leave' },
    { id: 3, name: 'Pedro Lopez', position: 'Accountant', status: 'Active' },
    { id: 4, name: 'Ana Reyes', position: 'IT Support', status: 'Resigned' },
]);

// Status Badge Class
const statusClass = (status) => {
    switch (status) {
        case 'Active': return 'bg-green-100 text-green-700';
        case 'On Leave': return 'bg-yellow-100 text-yellow-700';
        case 'Resigned': return 'bg-red-100 text-red-700';
        default: return 'bg-gray-100 text-gray-700';
    }
};

onMounted(() => {
    // Attendance Chart
    const ctxAttendance = attendanceChartCanvas.value.getContext('2d');
    new Chart(ctxAttendance, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
            datasets: [
                {
                    label: 'Present',
                    data: [5, 4, 5, 4, 5],
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
                    data: [0, 1, 0, 1, 0],
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
                    data: [1, 2, 1, 0, 1],
                    backgroundColor: 'rgba(234, 179, 8, 0.2)',
                    borderColor: 'rgba(234, 179, 8, 1)',
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(234, 179, 8, 1)',
                    fill: true,
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Days' } },
                x: { title: { display: true, text: 'Weeks' } }
            }
        }
    });

    // Compliance Chart
    const ctxCompliance = complianceChartCanvas.value.getContext('2d');
    new Chart(ctxCompliance, {
        type: 'polarArea',
        data: {
            labels: ['Submitted', 'Pending', 'Overdue'],
            datasets: [
                {
                    label: 'Compliance Submissions',
                    data: [15, 5, 3],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.5)', // Green
                        'rgba(234, 179, 8, 0.5)', // Yellow
                        'rgba(239, 68, 68, 0.5)'  // Red
                    ],
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'right' },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.label}: ${context.raw}`
                    }
                }
            }
        }
    });
});
</script>
