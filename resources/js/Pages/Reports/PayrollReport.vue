<template>
    <Head title="Payroll Report" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payroll / <span class="text-xs font-normal text-green-900">Employee Payroll Summary Report</span></h2>

                <!-- Filters -->
                <div class="flex items-center space-x-4">
                    <div>
                        <label class="block text-sm font-medium">Select Month:</label>
                        <input 
                            type="month" 
                            v-model="filters.month" 
                            class="input-field"
                            @change="updatePayrollDate"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Cut-off Period:</label>
                        <select v-model="filters.cutOff" class="input-field" @change="updatePayrollDate">
                            <option value="">All</option>
                            <option value="1-15">1-15</option>
                            <option value="16-30">16-30</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Export</label>
                        <button @click="exportToExcel" class="bg-green-100 hover:bg-green-200 py-2 px-4 rounded-md border border-green-500 text-gray-700"> 
                            <i class="fa-solid fa-download mr-2"></i>
                            Download
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <div id="payrollTable"  class="bg-white shadow-sm sm:rounded-lg p-6 max-w-6xl mx-auto">
            <!-- Report Header -->
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold uppercase">SANRYS FOREIGN CURRENCY EXCHANGE INC.</h1>
                <p class="text-sm font-semibold mt-2">
                    Payroll Date: {{ payrollDate }}
                </p>
            </div>

            <!-- Payroll Table -->
            <table class="text-xs w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 border border-gray-300">Employee Name</th>
                        <th class="p-4 border border-gray-300">Rate/Day</th>
                        <th class="p-4 border border-gray-300">Total Workdays</th>
                        <th class="p-4 border border-gray-300">Basic Salary</th>
                        <th class="p-4 border border-gray-300">Overtime Pay</th>
                        <th class="p-4 border border-gray-300">Holiday Pay</th>
                        <th class="p-4 border border-gray-300">Allowance</th>
                        <th class="p-4 border border-gray-300">Deductions</th>
                        <th class="p-4 border border-gray-300">Net Pay</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="payroll in payrolls" :key="payroll.id" class="hover:bg-gray-50">
                        <td class="p-4 border border-gray-300">{{ payroll.user.name }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.rate_per_day) }}</td>
                        <td class="p-4 border border-gray-300">{{ payroll.total_workdays }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.basic_salary) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.overtime_pay) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.holiday_pay) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.allowance) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.deductions) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(payroll.net_pay) }}</td>
                    </tr>

                    <!-- TOTAL ROW -->
                    <tr class="bg-gray-200 font-semibold">
                        <td colspan="3" class="p-4 border border-gray-300 text-right">TOTAL:</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(total.basic_salary) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(total.overtime_pay) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(total.holiday_pay) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(total.allowance) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(total.deductions) }}</td>
                        <td class="p-4 border border-gray-300">{{ formatCurrency(total.net_pay) }}</td>
                    </tr>

                    <tr v-if="payrolls.length === 0">
                        <td colspan="9" class="p-4 text-center text-gray-500">No records found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import * as XLSX from 'xlsx';

const props = defineProps({
    payrolls: { type: Array, required: true },
    selectedMonth: { type: String, required: true },
    selectedCutOff: { type: String, required: false }
});

// Filters
const filters = ref({
    month: props.selectedMonth,
    cutOff: props.selectedCutOff
});

// Payroll Date Display
const payrollDate = ref('');

// Update Payroll Date
const updatePayrollDate = () => {
    const monthText = new Date(filters.value.month).toLocaleString('default', { month: 'long', year: 'numeric' });
    const cutOffText = filters.value.cutOff || '';
    payrollDate.value = `Payroll Date: ${monthText} ${cutOffText}`.trim();
};

// Initialize payroll date on load
updatePayrollDate();

// Total Computation
const total = computed(() => ({
    basic_salary: props.payrolls.reduce((sum, payroll) => sum + parseFloat(payroll.basic_salary || 0), 0),
    overtime_pay: props.payrolls.reduce((sum, payroll) => sum + parseFloat(payroll.overtime_pay || 0), 0),
    holiday_pay: props.payrolls.reduce((sum, payroll) => sum + parseFloat(payroll.holiday_pay || 0), 0),
    allowance: props.payrolls.reduce((sum, payroll) => sum + parseFloat(payroll.allowance || 0), 0),
    deductions: props.payrolls.reduce((sum, payroll) => sum + parseFloat(payroll.deductions || 0), 0),
    net_pay: props.payrolls.reduce((sum, payroll) => sum + parseFloat(payroll.net_pay || 0), 0)
}));

// Format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(value);
};

const exportToExcel = () => {
    const table = document.getElementById('payrollTable');
    const workbook = XLSX.utils.table_to_book(table);
    XLSX.writeFile(workbook, 'Payroll_Report.xlsx');
};
</script>

<style scoped>
.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
th, td {
    text-align: center;
}
</style>
