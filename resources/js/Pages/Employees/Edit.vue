<template>
    <Head title="Edit Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
        </template>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 max-w-4xl mx-auto">
            <form @submit.prevent="updateEmployee">
                <!-- Personal Information -->
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
                </div>

                <!-- Skills -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Skills</h3>
                    <div v-for="(skill, index) in form.skills" :key="index" class="mb-4">
                        <input v-model="skill.skill_name" placeholder="Skill Name" class="input-field">
                        <input v-model="skill.proficiency_level" placeholder="Proficiency Level" class="input-field">
                        <input v-model="skill.description" placeholder="Description" class="input-field">
                        <button type="button" @click="removeSkill(index)" class="text-red-500">Remove</button>
                    </div>
                    <button type="button" @click="addSkill" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Skill</button>
                </div>

                <!-- Educational Background -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Educational Background</h3>
                    <div>
                        <input v-model="form.educational_background.college" placeholder="College" class="input-field">
                        <input v-model="form.educational_background.college_course" placeholder="College Course" class="input-field">
                        <input v-model="form.educational_background.college_school_year" placeholder="College School Year" class="input-field">
                        <input v-model="form.educational_background.secondary" placeholder="Secondary School" class="input-field">
                        <input v-model="form.educational_background.secondary_course" placeholder="Secondary Course" class="input-field">
                        <input v-model="form.educational_background.secondary_school_year" placeholder="Secondary School Year" class="input-field">
                        <input v-model="form.educational_background.elementary" placeholder="Elementary School" class="input-field">
                        <input v-model="form.educational_background.elementary_course" placeholder="Elementary Course" class="input-field">
                        <input v-model="form.educational_background.elementary_school_year" placeholder="Elementary School Year" class="input-field">
                    </div>
                </div>

                <!-- Previous Employment Records -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Previous Employment Records</h3>
                    <div v-for="(record, index) in form.previous_employment_records" :key="index" class="mb-4">
                        <input v-model="record.company_name" placeholder="Company Name" class="input-field">
                        <input v-model="record.position" placeholder="Position" class="input-field">
                        <input v-model="record.date_employed" type="date" placeholder="Date Employed" class="input-field">
                        <input v-model="record.salary" placeholder="Salary" class="input-field">
                        <input v-model="record.reason_of_leaving" placeholder="Reason of Leaving" class="input-field">
                        <button type="button" @click="removeEmploymentRecord(index)" class="text-red-500">Remove</button>
                    </div>
                    <button type="button" @click="addEmploymentRecord" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Record</button>
                </div>

                <!-- References -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">References</h3>
                    <div v-for="(reference, index) in form.references" :key="index" class="mb-4">
                        <input v-model="reference.name" placeholder="Name" class="input-field">
                        <input v-model="reference.contact" placeholder="Contact" class="input-field">
                        <input v-model="reference.occupation" placeholder="Occupation" class="input-field">
                        <input v-model="reference.relation" placeholder="Relation" class="input-field">
                        <button type="button" @click="removeReference(index)" class="text-red-500">Remove</button>
                    </div>
                    <button type="button" @click="addReference" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Reference</button>
                </div>

                <!-- Emergency Contacts -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Emergency Contacts</h3>
                    <div v-for="(contact, index) in form.emergency_contacts" :key="index" class="mb-4">
                        <input v-model="contact.name" placeholder="Name" class="input-field">
                        <input v-model="contact.address" placeholder="Address" class="input-field">
                        <input v-model="contact.contact" placeholder="Contact" class="input-field">
                        <input v-model="contact.relation" placeholder="Relation" class="input-field">
                        <button type="button" @click="removeEmergencyContact(index)" class="text-red-500">Remove</button>
                    </div>
                    <button type="button" @click="addEmergencyContact" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Contact</button>
                </div>

                <!-- Government Benefits -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Government Benefits</h3>
                    <div>
                        <input v-model="form.government_benefits.sss_no" placeholder="SSS No" class="input-field">
                        <input v-model="form.government_benefits.pag_ibig_no" placeholder="Pag-IBIG No" class="input-field">
                        <input v-model="form.government_benefits.philhealth_no" placeholder="PhilHealth No" class="input-field">
                        <input v-model="form.government_benefits.tin_no" placeholder="TIN No" class="input-field">
                        <input v-model="form.government_benefits.employee_no" placeholder="Employee No" class="input-field">
                        <input v-model="form.government_benefits.date_employed" type="date" placeholder="Date Employed" class="input-field">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 text-right">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">
                        Update Employee
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
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