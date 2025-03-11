<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees / <span class="text-xs font-normal text-green-900">Manage your employees</span></h2>
                </div>
                <div>
                    <a href="" class="bg-green-100 hover:bg-green-200 py-3 px-4 rounded-md border border-green-500 text-gray-700 mr-2"> <i class="fa-solid fa-download mr-2"></i> Download</a>
                    <a :href="route('employee.create')" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white"> <i class="fa-solid fa-user-plus mr-2"></i> Add New</a>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-gray-900">
                <div class="flex flex-col">
                    <div class="overflow-x-auto pb-4">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden rounded-lg">
                                <table class="table-auto min-w-full rounded-xl">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Full Name &amp; Email </th>
                                            <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Job Title </th>
                                            <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Contact Number </th>
                                            <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Branch </th>
                                            <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Status </th>
                                            <th scope="col" class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300">
                                        <tr v-for="employee in employees" :key="employee.id" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                            <td class="px-5 py-3">
                                                <div class="w-12 flex items-center gap-3">
                                                    <img :src="'/storage/' + employee?.profile?.profile_picture" alt="Profile Picture">
                                                    <div class="data">
                                                        <p class="font-normal text-sm text-gray-900">{{ employee.name }}</p>
                                                        <p class="font-normal text-xs leading-5 text-gray-400"> {{ employee.email }} </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{ employee?.profile?.position }} </td>
                                            <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{ employee?.profile?.contact_number }} </td>
                                            <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{ employee?.profile?.branch }} </td>
                                            <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                <div class="py-1.5 px-2.5 bg-emerald-50 rounded-full flex justify-center w-20 items-center gap-1">
                                                    <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="2.5" cy="3" r="2.5" fill="#059669"></circle>
                                                    </svg>
                                                    <span class="font-medium text-xs text-emerald-600 ">{{ employee?.status }}</span>
                                                </div>
                                            </td>
                                            <td class="flex p-5 justify-center items-center gap-0.5">
                                                <a :href="route('employee.show', employee.id)" 
                                                    class="bg-blue-100 text-sm hover:bg-blue-200 py-2 px-4 rounded-md border border-blue-500 text-blue-700">
                                                    <i class="fa-solid fa-eye"></i> View
                                                </a>
                                                <button @click="deleteEmployee(employee.id)" class="bg-red-100 text-sm hover:bg-red-200 py-2 px-4 rounded-md border border-red-500 text-red-700">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                                <a 
                                                    :href="route('employee.edit', employee.id)" 
                                                    class="bg-green-100 text-sm hover:bg-green-200 py-2 px-4 rounded-md border border-green-500 text-green-700">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Update Modal -->
        <div v-if="isUpdateModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg px-6 py-8 w-full max-w-md relative">
                <button @click="closeUpdateModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h3 class="text-lg font-semibold mb-4">Update Employee</h3>

                <form @submit.prevent="updateEmployee">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Name:</label>
                            <input v-model="updateForm.name" class="w-full p-2 border rounded" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Email:</label>
                            <input v-model="updateForm.email" class="w-full p-2 border rounded" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Position:</label>
                            <input v-model="updateForm.position" class="w-full p-2 border rounded" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Branch:</label>
                            <input v-model="updateForm.branch" class="w-full p-2 border rounded" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Contact Number:</label>
                            <input v-model="updateForm.contact_number" class="w-full p-2 border rounded" />
                        </div>

                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded w-full">
                            Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    employees: { type: Array, required: true }
});

// View modal state
const isViewModalOpen = ref(false);
const selectedEmployee = ref(null);

// Open the view modal
const openViewModal = (employee) => {
    selectedEmployee.value = employee;
    isViewModalOpen.value = true;
};

// Close the view modal
const closeViewModal = () => {
    isViewModalOpen.value = false;
    selectedEmployee.value = null;
};

// Delete employee function
const deleteEmployee = async (employeeId) => {
    if (confirm('Are you sure you want to delete this employee?')) {
        try {
            await axios.delete(`/api/employees/${employeeId}`);
            alert('Employee deleted successfully!');
            // Refresh the page or update the employee list
            window.location.reload();
        } catch (error) {
            console.error('Error deleting employee:', error);
            alert('Failed to delete employee. Please try again.');
        }
    }
};

const isUpdateModalOpen = ref(false);
const updateForm = ref({
    id: null,
    name: '',
    email: '',
    position: '',
    branch: '',
    contact_number: '',
});

// Open the update modal and populate the form
const openUpdateModal = (employee) => {
    updateForm.value = {
        id: employee.id,
        name: employee.name,
        email: employee.email,
        position: employee.profile?.position,
        branch: employee.profile?.branch,
        contact_number: employee.profile?.contact_number,
    };
    isUpdateModalOpen.value = true;
};

// Close the update modal
const closeUpdateModal = () => {
    isUpdateModalOpen.value = false;
    updateForm.value = {};
};

// Update employee function
const updateEmployee = async () => {
    try {
        await axios.put(`/api/employees/${updateForm.value.id}`, updateForm.value);
        alert('Employee updated successfully!');
        window.location.reload();
    } catch (error) {
        console.error('Error updating employee:', error);
        alert('Failed to update employee. Please try again.');
    }
};
    
</script>