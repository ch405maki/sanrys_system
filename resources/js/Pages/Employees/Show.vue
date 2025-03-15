<template>
    <Head title="Employee Info" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Employee Details
                </h2>
                <a 
                    :href="route('employee.edit', employee.id)" 
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-200">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profile
                </a>
            </div>
        </template>

        <div class="py-2">
            <div class="max-w-full mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 bg-white border-b border-gray-200">
                        <!-- Employee Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Profile Picture Section -->
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-gray-100 shadow-lg">
                                    <img
                                        :src="employee.profile.profile_picture ? `/storage/${employee.profile.profile_picture}` : '/images/default-profile.png'"
                                        alt="Profile Picture"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                                <h3 class="mt-4 text-xl font-semibold text-gray-800">{{ employee.name }}</h3>
                                <p class="text-sm text-gray-500">Position: {{ employee.profile.position }}</p>
                                <p class="text-sm text-gray-500">Employee No: {{ employee.government_benefits?.employee_no || 'No Employee Id' }}</p>
                                <p class="text-sm text-gray-500">Employment Date: {{ employee.government_benefits?.date_employed ||  'No Employment Date'}}</p>
                            </div>
                                                

                            <!-- Personal Information Section -->
                            <div class="col-span-2">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-500">Full Name</p>
                                        <p class="font-medium text-gray-900">{{ employee.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="font-medium text-gray-900">{{ employee.email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Branch</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.branch }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Contact Number</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.contact_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Date of Birth</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.date_of_birth }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Place of Birth</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.place_of_birth }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Civil Status</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.civil_status }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Citizenship</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.citizenship }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Religion</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.religion }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Height</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.height }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Weight</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.weight }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Present Address</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.present_address }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Permanent Address</p>
                                        <p class="font-medium text-gray-900">{{ employee.profile.permanent_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Skills Section -->
                        <div class="mt-12">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Skills and Other Qualifications</h3>
                            <div v-if="employee.skills.length > 0">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skill Name</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proficiency Level</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="(skill, index) in employee.skills" :key="index">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ skill.skill_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ skill.proficiency_level }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ skill.description }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No skills added.</p>
                        </div>

                        <!-- Educational BG -->
                        <div class="mt-12">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Educational Background</h3>
                            <div v-if="employee.educational_background">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <!-- College -->
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">College</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.college }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.college_course }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.college_school_year }}</td>
                                            </tr>
                                            <!-- Secondary -->
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Secondary</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.secondary }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.secondary_course }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.secondary_school_year }}</td>
                                            </tr>
                                            <!-- Elementary -->
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Elementary</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.elementary }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.elementary_course }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ employee.educational_background.elementary_school_year }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No educational background added.</p>
                        </div>

                        <div class="mt-12">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Previous Employment Records</h3>
                            <div v-if="employee.previous_employment_records.length > 0">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company Name</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Employed</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason of Leaving</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="(record, index) in employee.previous_employment_records" :key="index">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ record.company_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ record.position }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ record.date_employed }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ record.salary }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ record.reason_of_leaving }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No previous employment records added.</p>
                        </div>

                        <div class="mt-12">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">References</h3>
                            <div v-if="employee.references.length > 0">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Occupation</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relation</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="(reference, index) in employee.references" :key="index">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ reference.name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ reference.contact }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ reference.occupation }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ reference.relation }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No references added.</p>
                        </div>

                        <div class="mt-12">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6">Emergency Contacts</h3>
                                <div v-if="employee.emergency_contacts.length > 0">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white border border-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relation</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <tr v-for="(contact, index) in employee.emergency_contacts" :key="index">
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ contact.name }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ contact.address }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ contact.contact }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ contact.relation }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500">No emergency contacts added.</p>
                            </div>

                            <div class="mt-12">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6">Government Benefits</h3>
                                <div v-if="employee.government_benefits">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white border border-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SSS No</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pag-IBIG No</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PhilHealth No</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TIN No</th>
                                                 </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ employee.government_benefits.sss_no }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ employee.government_benefits.pag_ibig_no }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ employee.government_benefits.philhealth_no }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ employee.government_benefits.tin_no }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500">No government benefits added.</p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    employee: Object,
});
</script>