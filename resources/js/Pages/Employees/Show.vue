<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Employee Details
                </h2>
                <a 
                    :href="route('employee.edit', employee.id)" 
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profile
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Employee Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                                <div class="space-y-2">
                                    <p><strong>Name:</strong> {{ employee.name }}</p>
                                    <p><strong>Email:</strong> {{ employee.email }}</p>
                                    <p><strong>Position:</strong> {{ employee.profile.position }}</p>
                                    <p><strong>Branch:</strong> {{ employee.profile.branch }}</p>
                                    <p><strong>Age:</strong> {{ employee.profile.age }}</p>
                                    <p><strong>Contact Number:</strong> {{ employee.profile.contact_number }}</p>
                                    <p><strong>Sex:</strong> {{ employee.profile.sex }}</p>
                                    <p><strong>Civil Status:</strong> {{ employee.profile.civil_status }}</p>
                                    <p><strong>Citizenship:</strong> {{ employee.profile.citizenship }}</p>
                                    <p><strong>Religion:</strong> {{ employee.profile.religion }}</p>
                                    <p><strong>Weight:</strong> {{ employee.profile.weight }}</p>
                                    <p><strong>Height:</strong> {{ employee.profile.height }}</p>
                                    <p><strong>Date of Birth:</strong> {{ employee.profile.date_of_birth }}</p>
                                    <p><strong>Place of Birth:</strong> {{ employee.profile.place_of_birth }}</p>
                                    <p><strong>Present Address:</strong> {{ employee.profile.present_address }}</p>
                                    <p><strong>Permanent Address:</strong> {{ employee.profile.permanent_address }}</p>
                                </div>
                            </div>

                            <!-- Profile Picture -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Profile Picture</h3>
                                <img
                                    :src="employee.profile.profile_picture ? `/storage/${employee.profile.profile_picture}` : '/images/default-profile.png'"
                                    alt="Profile Picture"
                                    class="w-48 h-48 rounded-full object-cover"
                                />
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Skills and Other Qualifications</h3>
                            <div v-if="employee.skills.length > 0" class="space-y-4">
                                <div v-for="(skill, index) in employee.skills" :key="index" class="p-4 bg-gray-50 rounded-lg">
                                    <p><strong>Skill Name:</strong> {{ skill.skill_name }}</p>
                                    <p><strong>Proficiency Level:</strong> {{ skill.proficiency_level }}</p>
                                    <p><strong>Description:</strong> {{ skill.description }}</p>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No skills added.</p>
                        </div>

                        <!-- Educational Background -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Educational Background</h3>
                            <div v-if="employee.educational_background" class="space-y-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p><strong>College:</strong> {{ employee.educational_background.college }}</p>
                                    <p><strong>College Course:</strong> {{ employee.educational_background.college_course }}</p>
                                    <p><strong>College School Year:</strong> {{ employee.educational_background.college_school_year }}</p>
                                    <p><strong>Secondary:</strong> {{ employee.educational_background.secondary }}</p>
                                    <p><strong>Secondary Course:</strong> {{ employee.educational_background.secondary_course }}</p>
                                    <p><strong>Secondary School Year:</strong> {{ employee.educational_background.secondary_school_year }}</p>
                                    <p><strong>Elementary:</strong> {{ employee.educational_background.elementary }}</p>
                                    <p><strong>Elementary Course:</strong> {{ employee.educational_background.elementary_course }}</p>
                                    <p><strong>Elementary School Year:</strong> {{ employee.educational_background.elementary_school_year }}</p>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No educational background added.</p>
                        </div>

                        <!-- Previous Employment Records -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Previous Employment Records</h3>
                            <div v-if="employee.previous_employment_records.length > 0" class="space-y-4">
                                <div v-for="(record, index) in employee.previous_employment_records" :key="index" class="p-4 bg-gray-50 rounded-lg">
                                    <p><strong>Company Name:</strong> {{ record.company_name }}</p>
                                    <p><strong>Position:</strong> {{ record.position }}</p>
                                    <p><strong>Date Employed:</strong> {{ record.date_employed }}</p>
                                    <p><strong>Salary:</strong> {{ record.salary }}</p>
                                    <p><strong>Reason of Leaving:</strong> {{ record.reason_of_leaving }}</p>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No previous employment records added.</p>
                        </div>

                        <!-- References -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">References</h3>
                            <div v-if="employee.references.length > 0" class="space-y-4">
                                <div v-for="(reference, index) in employee.references" :key="index" class="p-4 bg-gray-50 rounded-lg">
                                    <p><strong>Name:</strong> {{ reference.name }}</p>
                                    <p><strong>Contact:</strong> {{ reference.contact }}</p>
                                    <p><strong>Occupation:</strong> {{ reference.occupation }}</p>
                                    <p><strong>Relation:</strong> {{ reference.relation }}</p>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No references added.</p>
                        </div>

                        <!-- Emergency Contacts -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Emergency Contacts</h3>
                            <div v-if="employee.emergency_contacts.length > 0" class="space-y-4">
                                <div v-for="(contact, index) in employee.emergency_contacts" :key="index" class="p-4 bg-gray-50 rounded-lg">
                                    <p><strong>Name:</strong> {{ contact.name }}</p>
                                    <p><strong>Address:</strong> {{ contact.address }}</p>
                                    <p><strong>Contact:</strong> {{ contact.contact }}</p>
                                    <p><strong>Relation:</strong> {{ contact.relation }}</p>
                                </div>
                            </div>
                            <p v-else class="text-gray-500">No emergency contacts added.</p>
                        </div>

                        <!-- Government Benefits -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Government Benefits</h3>
                            <div v-if="employee.government_benefits" class="p-4 bg-gray-50 rounded-lg">
                                <p><strong>SSS No:</strong> {{ employee.government_benefits.sss_no }}</p>
                                <p><strong>Pag-IBIG No:</strong> {{ employee.government_benefits.pag_ibig_no }}</p>
                                <p><strong>PhilHealth No:</strong> {{ employee.government_benefits.philhealth_no }}</p>
                                <p><strong>TIN No:</strong> {{ employee.government_benefits.tin_no }}</p>
                                <p><strong>Employee No:</strong> {{ employee.government_benefits.employee_no }}</p>
                                <p><strong>Date Employed:</strong> {{ employee.government_benefits.date_employed }}</p>
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
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    employee: Object,
});
</script>