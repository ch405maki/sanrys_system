    <template>
        <aside class="hidden w-64 bg-white md:block min-h-screen">
        <!-- Logo Section -->
        <div class="py-3 uppercase text-green-800 text-center tracking-widest mt-4 mb-8">
            <a href="/" class="">
            <h1 class="text-xl font-bold">SANRY'S</h1>
            <p class="text-sm">MONEY CHANGER</p>
            </a>
        </div>
    
        <!-- Navigation -->
        <nav class="text-sm text-gray-800">
            <ul class="flex flex-col space-y-1">
            <!-- Dashboard (No Dropdown) -->
            <li class="px-4 py-3 cursor-pointer bg-green-600 text-white hover:bg-green-700 flex items-center">
                <i class="fa-solid fa-house w-5 text-center mr-2"></i>
                <a href="/dashboard" class="w-full">Dashboard</a>
            </li>
    
            <!-- Reusable Dropdown -->
            <li v-for="(menu, key) in menus" :key="key" class="px-4 cursor-pointer hover:text-gray-900">
                <div @click="toggleDropdown(menu.key)" class="py-3 flex items-center justify-between">
                <div class="flex items-center">
                    <i :class="menu.icon" class="w-5 text-center mr-2"></i>
                    <span>{{ menu.label }}</span>
                </div>
                <i class="fa-solid fa-chevron-down w-5 text-center transition-transform duration-300" :class="{ 'rotate-180': openDropdown === menu.key }"></i>
                </div>
                <ul v-if="openDropdown === menu.key" class="ml-4 mt-1 border-l border-gray-300">
                <li v-for="(sub, index) in menu.submenus" :key="index" class="py-2 pl-8 cursor-pointer  hover:text-gray-900    flex items-center">
                    <i :class="sub.icon" class="w-5 text-center mr-2"></i>
                    <a :href="sub.link" class="w-full">{{ sub.label }}</a>
                </li>
                </ul>
            </li>
            <li class="border-b py-4"></li>
            <li class="px-4 py-3 cursor-pointer text-gray-800 hover:bg-green-700 hover:text-white  flex items-center">
                <i class="fa-solid fa-user mr-2 w-5"></i>
                <a :href="route('profile.edit')" class="w-full">Profile</a>
            </li>
            <li class="px-4 py-3 cursor-pointer text-red-500 hover:text-red-700 hover:bg-rose-200  flex items-center">
                <i class="fa-solid fa-right-from-bracket mr-2 w-5"></i>
                <a :href="route('logout')" class="w-full ">logout</a>
            </li>
            </ul>
        </nav>
        </aside>
    </template>
    
    <script setup>
    import { ref } from 'vue';
    
    // State to track which dropdown is open
    const openDropdown = ref(null);
    
    // Toggle dropdown function
    const toggleDropdown = (menu) => {
        openDropdown.value = openDropdown.value === menu ? null : menu;
    };
    
    // Sidebar menu structure
    const menus = ref([
        {
        key: 'employee',
        label: 'Employee',
        icon: 'fa-solid fa-user-group',
        submenus: [
            { label: 'Employee List', link: '/employee', icon: 'fa-solid fa-list' },
            { label: 'Add Employee', link: '/employee/create', icon: 'fa-solid fa-user-plus' }
        ]
        },
        {
        key: 'timeEntries',
        label: 'Time Entries',
        icon: 'fa-regular fa-clock',
        submenus: [
            { label: 'View Entries', link: '/time', icon: 'fa-solid fa-list' }
        ]
        },
        {
        key: 'attendance',
        label: 'Attendance',
        icon: 'fa-solid fa-calendar-check',
        submenus: [
            { label: 'View Attendance', link: '/attendance', icon: 'fa-solid fa-list' }
        ]
        },
        {
        key: 'payroll',
        label: 'Payroll',
        icon: 'fa-solid fa-money-bill',
        submenus: [
            { label: 'Process Payroll', link: '/payroll', icon: 'fa-solid fa-list' },
            { label: 'Payslip', link: '/payroll', icon: 'fa-solid fa-list' }
        ]
        },
        {
        key: 'contributions',
        label: 'Contributions',
        icon: 'fa-solid fa-piggy-bank',
        submenus: [
            { label: 'View Contributions', link: '/contributions', icon: 'fa-solid fa-list' },
            { label: 'My Contributions', link: '/contributions', icon: 'fa-solid fa-list' },
        ]
        },
        {
        key: 'documents',
        label: 'Documents',
        icon: 'fa-solid fa-file-alt',
        submenus: [
            { label: 'View Documents', link: '/documents', icon: 'fa-solid fa-list' },
            { label: 'My Documents', link: '/documents/mydocs', icon: 'fa-solid fa-list' },
        ]
        },
        {
        key: 'compliance',
        label: 'Compliance',
        icon: 'fa-solid fa-list-check',
        submenus: [
            { label: 'View Compliance', link: '/compliance', icon: 'fa-solid fa-list' },
            { label: 'My Compliance', link: '/compliance/show', icon: 'fa-solid fa-list' },
        ]
        }
    ]);
    </script>
    
    <style scoped>
    .rotate-180 {
        transform: rotate(180deg);
    }
    </style>
    