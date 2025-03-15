<template>
    <Head title="Edit Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
        </template>

        <div class="bg-white shadow-sm sm:rounded-lg p-8 max-w-7xl mx-auto">
            <form @submit.prevent="updateEmployee" class="space-y-8">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input v-model="form.name" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input v-model="form.email" type="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                            <input v-model="form.position" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Branch</label>
                            <input v-model="form.branch" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                            <input v-model="form.contact_number" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                            <input v-model="form.age" type="number" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sex</label>
                            <input v-model="form.sex" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Civil Status</label>
                            <input v-model="form.civil_status" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Citizenship</label>
                            <input v-model="form.citizenship" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Religion</label>
                            <input v-model="form.religion" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                            <input v-model="form.weight" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                            <input v-model="form.height" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                            <input v-model="form.date_of_birth" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Place of Birth</label>
                            <input v-model="form.place_of_birth" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Present Address</label>
                            <input v-model="form.present_address" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permanent Address</label>
                            <input v-model="form.permanent_address" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Skills</h3>
                    <div v-for="(skill, index) in form.skills" :key="index" class="mb-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input v-model="skill.skill_name" placeholder="Skill Name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="skill.proficiency_level" placeholder="Proficiency Level" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="skill.description" placeholder="Description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" @click="removeSkill(index)" class="text-red-500 hover:text-red-700 text-sm">Remove Skill</button>
                    </div>
                    <button type="button" @click="addSkill" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add Skill</button>
                </div>

                <!-- Educational Background -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Educational Background</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">College</label>
                            <input v-model="form.educational_background.college" placeholder="College" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">College Course</label>
                            <input v-model="form.educational_background.college_course" placeholder="College Course" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">College School Year</label>
                            <input v-model="form.educational_background.college_school_year" placeholder="College School Year" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary School</label>
                            <input v-model="form.educational_background.secondary" placeholder="Secondary School" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Course</label>
                            <input v-model="form.educational_background.secondary_course" placeholder="Secondary Course" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary School Year</label>
                            <input v-model="form.educational_background.secondary_school_year" placeholder="Secondary School Year" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Elementary School</label>
                            <input v-model="form.educational_background.elementary" placeholder="Elementary School" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Elementary Course</label>
                            <input v-model="form.educational_background.elementary_course" placeholder="Elementary Course" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Elementary School Year</label>
                            <input v-model="form.educational_background.elementary_school_year" placeholder="Elementary School Year" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Previous Employment Records -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Previous Employment Records</h3>
                    <div v-for="(record, index) in form.previous_employment_records" :key="index" class="mb-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input v-model="record.company_name" placeholder="Company Name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="record.position" placeholder="Position" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="record.date_employed" type="date" placeholder="Date Employed" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="record.salary" placeholder="Salary" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="record.reason_of_leaving" placeholder="Reason of Leaving" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" @click="removeEmploymentRecord(index)" class="text-red-500 hover:text-red-700 text-sm">Remove Record</button>
                    </div>
                    <button type="button" @click="addEmploymentRecord" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add Record</button>
                </div>

                <!-- References -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">References</h3>
                    <div v-for="(reference, index) in form.references" :key="index" class="mb-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input v-model="reference.name" placeholder="Name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="reference.contact" placeholder="Contact" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="reference.occupation" placeholder="Occupation" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="reference.relation" placeholder="Relation" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" @click="removeReference(index)" class="text-red-500 hover:text-red-700 text-sm">Remove Reference</button>
                    </div>
                    <button type="button" @click="addReference" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add Reference</button>
                </div>

                <!-- Emergency Contacts -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Emergency Contacts</h3>
                    <div v-for="(contact, index) in form.emergency_contacts" :key="index" class="mb-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input v-model="contact.name" placeholder="Name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="contact.address" placeholder="Address" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="contact.contact" placeholder="Contact" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input v-model="contact.relation" placeholder="Relation" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" @click="removeEmergencyContact(index)" class="text-red-500 hover:text-red-700 text-sm">Remove Contact</button>
                    </div>
                    <button type="button" @click="addEmergencyContact" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add Contact</button>
                </div>

                <!-- Government Benefits -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Government Benefits</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SSS No</label>
                            <input v-model="form.government_benefits.sss_no" placeholder="SSS No" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pag-IBIG No</label>
                            <input v-model="form.government_benefits.pag_ibig_no" placeholder="Pag-IBIG No" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">PhilHealth No</label>
                            <input v-model="form.government_benefits.philhealth_no" placeholder="PhilHealth No" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">TIN No</label>
                            <input v-model="form.government_benefits.tin_no" placeholder="TIN No" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employee No</label>
                            <input v-model="form.government_benefits.employee_no" placeholder="Employee No" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Employed</label>
                            <input v-model="form.government_benefits.date_employed" type="date" placeholder="Date Employed" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 text-right">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-md transition duration-200">
                        Update Employee
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    employee: { type: Object, required: true }
});

const form = useForm({
    ...props.employee,
    ...props.employee.profile,
    skills: props.employee.skills,
    educational_background: props.employee.educational_background || {},
    previous_employment_records: props.employee.previous_employment_records,
    references: props.employee.references,
    emergency_contacts: props.employee.emergency_contacts,
    government_benefits: props.employee.government_benefits || {},
});

const addSkill = () => {
    form.skills.push({ skill_name: '', proficiency_level: '', description: '' });
};

const removeSkill = (index) => {
    form.skills.splice(index, 1);
};

const addEmploymentRecord = () => {
    form.previous_employment_records.push({
        company_name: '', position: '', date_employed: '', salary: '', reason_of_leaving: ''
    });
};

const removeEmploymentRecord = (index) => {
    form.previous_employment_records.splice(index, 1);
};

const addReference = () => {
    form.references.push({ name: '', contact: '', occupation: '', relation: '' });
};

const removeReference = (index) => {
    form.references.splice(index, 1);
};

const addEmergencyContact = () => {
    form.emergency_contacts.push({ name: '', address: '', contact: '', relation: '' });
};

const removeEmergencyContact = (index) => {
    form.emergency_contacts.splice(index, 1);
};

const updateEmployee = () => {
    form.put(route('employee.update', props.employee.id), {
        onSuccess: () => {
            toast.success('Employee updated successfully!');
        },
        onError: (errors) => {
            toast.error('Failed to update employee. Please check the form for errors.');
            console.error('Validation errors:', errors);
        }
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