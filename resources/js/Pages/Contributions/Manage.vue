<template>
    <div class="p-6 bg-white rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Manage Deductions</h2>

        <div class="mb-4">
            <label class="block text-sm font-medium">Select User:</label>
            <select v-model="form.user_id" class="border p-2 rounded-md w-full">
                <option v-for="user in users" :key="user.id" :value="user.id">
                    {{ user.name }} ({{ user.email }})
                </option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Pag-IBIG:</label>
                <input v-model="form.pag_ibig" type="number" class="border p-2 rounded-md w-full" />
            </div>
            <div>
                <label class="block text-sm font-medium">SSS:</label>
                <input v-model="form.sss" type="number" class="border p-2 rounded-md w-full" />
            </div>
            <div>
                <label class="block text-sm font-medium">PhilHealth:</label>
                <input v-model="form.philhealth" type="number" class="border p-2 rounded-md w-full" />
            </div>
            <div>
                <label class="block text-sm font-medium">Maxicare:</label>
                <input v-model="form.maxicare" type="number" class="border p-2 rounded-md w-full" />
            </div>
        </div>

        <button
            @click="saveDeduction"
            class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
        >
            Save Deduction
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    users: { type: Array, required: true }
});

const form = ref({
    user_id: '',
    pag_ibig: 0,
    sss: 0,
    philhealth: 0,
    maxicare: 0
});

// Save deductions using Axios
const saveDeduction = async () => {
    try {
        await axios.post('/api/deductions/store', form.value);
        alert('Deduction saved successfully!');
    } catch (error) {
        console.error('Error:', error.response?.data || error.message);
        alert('Failed to save deduction.');
    }
};
</script>
