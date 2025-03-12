<template>
    <Head title="Payroll" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Payroll / <span class="text-xs font-normal text-green-900">Manage Payroll</span>
                    </h2>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Payroll Date Selection Form -->
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="flex gap-2">
                        <input 
                        v-model="startDate" 
                        type="date" 
                        class="border p-2 rounded-md w-40"
                    />
                    <input 
                        v-model="endDate" 
                        type="date" 
                        class="border p-2 rounded-md w-40"
                    />
                    </div>
                    <div>
                        <button 
                            @click="generatePayrollForAll"
                            class="bg-green-100 hover:bg-green-200 py-2 px-4 rounded-md border border-green-500 text-gray-700">
                            <i class="fa-solid fa-circle-notch"></i> Generate All
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden rounded-lg">
                            <table class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Full Name &amp; Email</th>
                                        <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Contact Number</th>
                                        <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Job Title</th>
                                        <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Branch</th>
                                        <th scope="col" class="p-5 text-center text-sm leading-6 font-semibold text-gray-900 capitalize">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300">
                                    <tr v-for="user in users" :key="user.id" class="bg-white hover:bg-gray-50">
                                        <td class="px-5 py-3">
                                            <div class="w-12 flex items-center gap-3">
                                                <img :src="'/storage/' + user?.profile?.profile_picture" alt="Profile Picture" class="h-10 w-10 rounded-full">
                                                <div class="data">
                                                    <p class="font-normal text-sm text-gray-900">{{ user.name }}</p>
                                                    <p class="font-normal text-xs leading-5 text-gray-400">{{ user.email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-5 text-sm text-gray-900">{{ user?.profile?.contact_number }}</td>
                                        <td class="p-5 text-sm text-gray-900">{{ user?.profile?.position }}</td>
                                        <td class="p-5 text-sm text-gray-900">{{ user?.profile?.branch }}</td>
                                        <td class="flex p-5 items-center justify-center gap-0.5">
                                            <button 
                                                @click="generatePayroll(user.id)" 
                                                class="bg-green-100 text-sm hover:bg-green-200 py-2 px-4 rounded-md border border-green-500 text-gray-700">
                                                <i class="fa-solid fa-outdent"></i> Generate Payroll
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Display Generated Payroll Data -->
                <div v-if="payrollData && payrollData.length" class="mt-8 bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Generated Payroll Details</h3>
                    <ul v-for="payroll in payrollData" :key="payroll.user">
                        <li><strong>User:</strong> {{ payroll.user }}</li>
                        <li><strong>Total Workdays:</strong> {{ payroll.total_workdays }}</li>
                        <li><strong>Cut-off Period:</strong> {{ payroll.cut_off_period }}</li>
                        <li><strong>Basic Salary:</strong> {{ payroll.basic_salary }}</li>
                        <li><strong>Overtime Pay:</strong> {{ payroll.overtime_pay }}</li>
                        <li><strong>Holiday Pay:</strong> {{ payroll.holiday_pay }}</li>
                        <li><strong>Gross Pay:</strong> {{ payroll.gross_pay }}</li>
                        <li><strong>Net Pay:</strong> {{ payroll.net_pay }}</li>
                        <hr class="my-2">
                    </ul>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>


<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    users: { type: Array, required: true }
});

// Form data for payroll generation
const startDate = ref('');
const endDate = ref('');
const payrollData = ref(null); // To store the generated payroll data

// Function to generate payroll for a single user
const generatePayroll = async (userId) => {
    if (!startDate.value || !endDate.value) {
        toast.error('Please enter both start and end dates.');
        return;
    }

    try {
        const response = await axios.post(`/api/payroll/generate/${userId}`, {
            startDate: startDate.value,
            endDate: endDate.value
        });

        payrollData.value = response.data;
        toast.success('Payroll generated successfully!');
    } catch (error) {
        console.error('Error generating payroll:', error.response?.data?.message || error.message);
        toast.error('Failed to generate payroll. Please try again.');
    }
};

// Function to generate payroll for all users
const generatePayrollForAll = async () => {
    if (!startDate.value || !endDate.value) {
        toast.error('Please enter both start and end dates.');
        return;
    }

    try {
        const response = await axios.post('/api/payroll/generate-all', {
            startDate: startDate.value,
            endDate: endDate.value
        });

        payrollData.value = response.data.payrollDetails;
        toast.success('Payroll for all users generated successfully!');
    } catch (error) {
        console.error('Error generating payroll:', error.response?.data?.message || error.message);
        toast.error('Failed to generate payroll. Please try again.');
    }
};
</script>
