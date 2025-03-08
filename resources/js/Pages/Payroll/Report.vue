<template>
    <Head title="Payroll" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Reports / <span class="text-xs font-normal text-green-900">Payroll Report</span>
                    </h2>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Payroll Date Selection Form -->
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="flex gap-2">
                        <!-- Filter -->
                    </div>
                    <div>
                        <!-- Button -->
                    </div>
                </div>
                <div v-for="user in users" :key="user.id" class="mb-6 p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-bold text-green-600">{{ user.name }}</h2>
                    <p class="text-gray-600">{{ user.email }}</p>

                    <table v-if="user.payrolls.length" class="mt-4 w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-green-100">
                                <th class="p-2 border">Total Workdays</th>
                                <th class="p-2 border">Basic Salary</th>
                                <th class="p-2 border">Overtime Pay</th>
                                <th class="p-2 border">Holiday Pay</th>
                                <th class="p-2 border">Allowance</th>
                                <th class="p-2 border">Gross Pay</th>
                                <th class="p-2 border">Net Pay</th>
                                <th class="p-2 border">Cut-off Period</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="payroll in user.payrolls" :key="payroll.id" class="bg-gray-50">
                                <td class="p-2 border">{{ payroll.total_workdays }}</td>
                                <td class="p-2 border">{{ payroll.basic_salary }}</td>
                                <td class="p-2 border">{{ payroll.overtime_pay }}</td>
                                <td class="p-2 border">{{ payroll.holiday_pay }}</td>
                                <td class="p-2 border">{{ payroll.allowance }}</td>
                                <td class="p-2 border">{{ payroll.gross_pay }}</td>
                                <td class="p-2 border">{{ payroll.net_pay }}</td>
                                <td class="p-2 border">{{ payroll.cut_off_period }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <p v-else class="text-red-500 mt-2">No payroll data available.</p>
                </div>
                <div class="overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden rounded-lg">
                            <table class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Full Name &amp; Email</th>
                                        <th scope="col" class="p-5 text-center text-sm leading-6 font-semibold text-gray-900 capitalize">Total Gross</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300">
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-5 py-3">
                                            <div class="w-12 flex items-center gap-3">
                                                <img :src="'/storage/' + user?.profile?.profile_picture" alt="Profile Picture" class="h-10 w-10 rounded-full">
                                                <div class="data">
                                                    <p class="font-normal text-sm text-gray-900">{{ user.name }}</p>
                                                    <p class="font-normal text-xs leading-5 text-gray-400">{{ user.email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-5 text-sm text-gray-900">{{ user?.payrolls?.gross_pay }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

const props = defineProps({
    users: { type: Array, required: true }
});

</script>