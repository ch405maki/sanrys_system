<template>
    <AuthenticatedLayout>
    <Head title="Payslip" />
    <template #header>
        <div class="flex justify-between items-center ">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <select id="cut-off-period" v-model="selectedCutOff" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1-15">Cut-Off Period 1-15</option>
                        <option value="16-31">Cut-Off Period 16-31</option>
                    </select>
                </div>
                <div>
                    <input type="month" id="month" v-model="selectedMonth" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button @click="filterPayslip" :disabled="isLoading" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <span v-if="isLoading">Loading...</span>
                    <span v-else><i class="fa-solid fa-filter"></i> Filter Payslip</span>
                </button>
                    <a href="" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-file-export"></i> Export</a>
            </div>
        </div>
    </template>
    <div>
        <div class="p-6 bg-white shadow-lg rounded-lg">
            <div v-if="payroll">
            <div class="px-10 py-10  mx-auto">
                <div class="uppercase text-center mb-14">
                    <div class="text-green-600 font-semibold text-2xl">SANRYS FOREIGN CURRENCY EXCHANGE INC.</div>
                    <h1 class="text-xl font-bold text-gray-700">Payslip</h1>
                </div>

                <div class="border-b-2 border-dashed border-gray-300 pb-8 mb-8">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-xl text-gray-700 mb-2  font-bold uppercase">{{ user.name }}</h2>
                            <div class="text-gray-700">Position: {{ user?.profile?.position }}</div>
                            <div class="text-gray-700">Branch: {{ user?.profile?.branch }}</div>
                            <div class="text-gray-700">Email: {{ user.email }}</div>
                            <div class="text-gray-700">Address: {{ user?.profile?.present_address }}</div>
                        </div>
                        <div class="text-gray-700">
                            <div class="font-bold text-xl mb-2">PAY PERIOD</div>
                            <div class="text-sm">Date Start: {{ payroll.pay_period_start }}</div>
                            <div class="text-sm">Date End: {{ payroll.pay_period_end }}</div>
                            <div class="text-sm">Cut Off: {{ payroll.cut_off_period }}</div>
                        </div>
                    </div>
                </div>
                <table class="w-full text-left mb-8">
                    <thead>
                        <tr>
                            <th class="text-gray-700 font-bold uppercase py-2">Brakedown</th>
                            <th class="text-gray-700 font-bold uppercase p-2 bg-gray-100">Total</th>
                        </tr>   
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 text-gray-700">Total Work Day</td>
                            <td class="p-2 bg-gray-100 text-gray-700">{{ total_workdays }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-700">Basic Salary</td>
                            <td class="p-2 bg-gray-100 text-gray-700">₱{{ payroll.basic_salary }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-700">Overtime Pay</td>
                            <td class="p-2 bg-gray-100 text-gray-700">₱{{ payroll.overtime_pay }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-700">Holiday Pay</td>
                            <td class="p-2 bg-gray-100 text-gray-700">₱{{ payroll.holiday_pay }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-700">Allowance</td>
                            <td class="p-2 bg-gray-100 text-gray-700">₱{{ payroll.allowance }}</td>
                        </tr>
                        <tr class="border-t border-gray-300 border-dashed">
                            <td class="py-2 text-gray-700">SSS</td>
                            <td class="p-2 bg-gray-100 text-gray-700">₱</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-700">Philhealth</td>
                            <td class="p-2 bg-gray-100 text-gray-700">₱</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-700">Total Deductions</td>
                            <td class="p-2 bg-red-100 text-gray-700">₱{{ payroll.deductions }}</td>
                        </tr>
                        <tr class="border-t border-dashed border-gray-300 ">
                            <td class="py-2 text-gray-700"></td>
                            <td class="p-2 bg-green-100 text-gray-700 font-bold text-lg">Total Pay: ₱ {{ payroll.net_pay }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="border-t-2 border-dashed border-gray-300 pt-8 mb-8">
                    <div class="text-gray-400 mb-2 italic">Sanry's Foreign Currency Exchange Inc. </div>
                </div>
            </div>
            </div>
            <div v-else>
                <p class="text-red-500">No payroll record found for the selected cut-off period and month.</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    payroll: Object,
    user: Object,
    profile: Object,
    total_workdays: Number, 
});

const selectedCutOff = ref('1-15');
const selectedMonth = ref(new Date().toISOString().slice(0, 7)); // Default to current month
const isLoading = ref(false); // Add a loading state

const filterPayslip = () => {
    isLoading.value = true; // Set loading to true
    Inertia.get('/filter-payslip', {
        cut_off_period: selectedCutOff.value,
        month: selectedMonth.value
    }, {
        onFinish: () => {
            isLoading.value = false; // Reset loading state
        }
    });
};
</script>