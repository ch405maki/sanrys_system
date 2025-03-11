<template>
    <Head title="Edit Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
        </template>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 max-w-4xl mx-auto">
            <form @submit.prevent="updateEmployee">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium">Name:</label>
                        <input v-model="form.name" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email:</label>
                        <input v-model="form.email" type="email" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Position:</label>
                        <input v-model="form.position" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Branch:</label>
                        <input v-model="form.branch" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Contact Number:</label>
                        <input v-model="form.contact_number" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Age:</label>
                        <input v-model="form.age" type="number" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Sex:</label>
                        <input v-model="form.sex" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Civil Status:</label>
                        <input v-model="form.civil_status" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Citizenship:</label>
                        <input v-model="form.citizenship" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Religion:</label>
                        <input v-model="form.religion" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Weight:</label>
                        <input v-model="form.weight" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Height:</label>
                        <input v-model="form.height" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Date of Birth:</label>
                        <input v-model="form.date_of_birth" type="date" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Place of Birth:</label>
                        <input v-model="form.place_of_birth" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Present Address:</label>
                        <input v-model="form.present_address" type="text" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Permanent Address:</label>
                        <input v-model="form.permanent_address" type="text" class="input-field">
                    </div>

                    <div class="col-span-2 text-right">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">
                            Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    employee: { type: Object, required: true }
});

const form = useForm({
    ...props.employee,
    ...props.employee.profile
});

// Update Employee Function
const updateEmployee = () => {
    form.put(route('employee.update', props.employee.id), {
        onSuccess: () => alert('Employee updated successfully!'),
        onError: () => alert('Failed to update employee. Please try again.')
    });
};
</script>

<style scoped>
.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
    