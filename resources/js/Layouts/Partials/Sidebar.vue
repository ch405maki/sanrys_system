<template>
    <aside class="hidden w-64 bg-white md:block min-h-screen">
        <!-- Logo Section -->
        <div class="py-3 uppercase text-green-800 text-center tracking-widest mt-4 mb-8">
            <a href="/" class="">
                <h1 class="text-xl font-bold">SANRY'S</h1>
                <p class="text-sm">MONEY CHANGER</p>
            </a>
        </div>

        <!-- Navigation admin-->
        <div v-if="user.role === 'administrator'">
        <nav class="text-sm text-gray-800">
            <ul class="flex flex-col space-y-1">
                <!-- Dashboard (No Dropdown) -->
                <li class="px-4 py-3 cursor-pointer bg-green-600 text-white hover:bg-green-700 flex items-center">
                    <i class="fa-solid fa-house w-5 text-center mr-2"></i>
                    <a href="/dashboard" class="w-full">Dashboard</a>
                </li>

                <!-- Employee Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('employee')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-user-group w-5 text-center mr-2"></i>
                            <span>Employee</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'employee' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'employee'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/employee" class="w-full">Employee List</a>
                        </li>
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-user-plus w-5 text-center mr-2"></i>
                            <a href="/employee/create" class="w-full">Add Employee</a>
                        </li>
                        <li class="py-2 pl-8 cursor-pointer hover:text-red-700 text-red-500 flex items-center border-t">
                            <i class="fa-solid fa-user w-4 text-center mr-3"></i>
                            <a href="/employee/archive" class="w-full">Employee Archive</a>
                        </li>
                    </ul>
                </li>

                <!-- Time Entries Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('timeEntries')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-regular fa-clock w-5 text-center mr-2"></i>
                            <span>Time Entries</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'timeEntries' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'timeEntries'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/time" class="w-full">View Entries</a>
                        </li>
                    </ul>
                </li>

                <!-- Attendance Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('attendance')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-calendar-check w-5 text-center mr-2"></i>
                            <span>Attendance</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'attendance' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'attendance'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/attendance" class="w-full">View Attendance</a>
                        </li>
                    </ul>
                </li>

                <!-- Payroll Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('payroll')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-money-bill w-5 text-center mr-2"></i>
                            <span>Payroll</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'payroll' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'payroll'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/payroll" class="w-full">Process Payroll</a>
                        </li>
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/payslip" class="w-full">Payslip</a>
                        </li>
                    </ul>
                </li>

                <!-- Contributions Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('contributions')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-piggy-bank w-5 text-center mr-2"></i>
                            <span>Contributions</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'contributions' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'contributions'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/contributions" class="w-full">Manage Contributions</a>
                        </li>
                    </ul>
                </li>

                <!-- Salary Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('salary')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-coins w-5 text-center mr-2"></i>
                            <span>Salary</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'salary' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'salary'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/salary" class="w-full">Manage Salary</a>
                        </li>
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/salary/show" class="w-full">My Salary</a>
                        </li>
                    </ul>
                </li>

                <!-- Documents Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('documents')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-file-alt w-5 text-center mr-2"></i>
                            <span>Documents</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'documents' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'documents'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/documents" class="w-full">View Documents</a>
                        </li>
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/documents/mydocs" class="w-full">My Documents</a>
                        </li>
                    </ul>
                </li>

                <!-- Reports Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('Reports')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-file-alt w-5 text-center mr-2"></i>
                            <span>Reports</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'Reports' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'Reports'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/reports/payroll" class="w-full">Payroll Report</a>
                        </li>
                    </ul>
                </li>

                <!-- Profile -->
                <li class="px-4 py-3 border-t cursor-pointer text-gray-800 hover:bg-green-700 hover:text-white flex items-center">
                    <i class="fa-solid fa-user mr-2 w-5"></i>
                    <a :href="route('profile.edit')" class="w-full">Profile</a>
                </li>

                <!-- Logout -->
                <li class="px-4 py-3 cursor-pointer text-red-500 hover:text-red-700 hover:bg-rose-200 flex items-center">
                    <i class="fa-solid fa-right-from-bracket mr-2 w-5"></i>
                    <a :href="route('logout')" class="w-full">Logout</a>
                </li>
            </ul>
        </nav>
        </div>

        <!-- Navigation staff-->
        <div v-if="user.role != 'administrator'">
        <nav class="text-sm text-gray-800">
            <ul class="flex flex-col space-y-1">
                <!-- Dashboard (No Dropdown) -->
                <li class="px-4 py-3 cursor-pointer bg-green-600 text-white hover:bg-green-700 flex items-center">
                    <i class="fa-solid fa-house w-5 text-center mr-2"></i>
                    <a href="/dashboard" class="w-full">Dashboard</a>
                </li>

                <!-- Time Entries Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('timeEntries')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-regular fa-clock w-5 text-center mr-2"></i>
                            <span>Time Entries</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'timeEntries' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'timeEntries'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/time" class="w-full">View Entries</a>
                        </li>
                    </ul>
                </li>

                <!-- Payroll Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('payroll')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-money-bill w-5 text-center mr-2"></i>
                            <span>Payroll</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'payroll' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'payroll'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/payslip" class="w-full">Payslip</a>
                        </li>
                    </ul>
                </li>

                <!-- Salary Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('salary')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-coins w-5 text-center mr-2"></i>
                            <span>Salary</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'salary' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'salary'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/salary/show" class="w-full">My Salary</a>
                        </li>
                    </ul>
                </li>

                <!-- Documents Dropdown -->
                <li class="px-4 cursor-pointer hover:text-gray-900">
                    <div @click="toggleDropdown('documents')" class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-file-alt w-5 text-center mr-2"></i>
                            <span>Documents</span>
                        </div>
                        <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === 'documents' }"></i>
                    </div>
                    <ul v-if="openDropdown === 'documents'" class="ml-4 mt-1 border-l border-gray-300">
                        <li class="py-2 pl-8 cursor-pointer hover:text-gray-900 flex items-center">
                            <i class="fa-solid fa-list w-5 text-center mr-2"></i>
                            <a href="/documents/mydocs" class="w-full">My Documents</a>
                        </li>
                    </ul>
                </li>

                <!-- Profile -->
                <li class="px-4 py-3 border-t cursor-pointer text-gray-800 hover:bg-green-700 hover:text-white flex items-center">
                    <i class="fa-solid fa-user mr-2 w-5"></i>
                    <a :href="route('profile.edit')" class="w-full">Profile</a>
                </li>

                <!-- Logout -->
                <li class="px-4 py-3 cursor-pointer text-red-500 hover:text-red-700 hover:bg-rose-200 flex items-center">
                    <i class="fa-solid fa-right-from-bracket mr-2 w-5"></i>
                    <a :href="route('logout')" class="w-full">Logout</a>
                </li>
            </ul>
        </nav>
        </div>
    </aside>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { usePage } from '@inertiajs/vue3';

// State to track which dropdown is open
const openDropdown = ref(null);

// Toggle dropdown function
const toggleDropdown = (menu) => {
    openDropdown.value = openDropdown.value === menu ? null : menu;
};

const { props } = usePage();
const user = props.auth.user;
</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>