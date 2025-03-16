<template>
    <Head title="Documents" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee / <span class="text-xs font-normal text-green-900">Add New Employee</span></h2>
                </div>
                <div>
                    <a :href="route('employee.index')" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white"><i class="fa-solid fa-arrow-left mr-2"></i> Back</a>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form @submit.prevent="submitForm" class="px-4 md:px-8 max-w-7xl mx-auto py-12">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">This information will be accessible by our administrator.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <!-- Profile Picture -->
                                <div class="col-span-full">
                                    <label for="profile_picture" class="block text-sm font-medium leading-6 text-gray-900">Profile Picture</label>
                                    <div class="mt-2 flex items-center gap-x-3">
                                        <svg v-if="!form.profile_picture" class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <img v-else :src="previewProfilePicture" class="h-12 w-12 rounded-full object-cover" />

                                        <input type="file" id="profile_picture" ref="fileInput" @change="handleFileUpload" class="hidden" />
                                        
                                        <button type="button" @click="openFilePicker"
                                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                            Upload
                                        </button>
                                    </div>
                                    <p v-if="errors.profile_picture" class="mt-2 text-sm text-red-600">{{ errors.profile_picture[0] }}</p>
                                </div>

                                <!-- Full Name -->
                                <div class="sm:col-span-4">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full name</label>
                                    <div class="mt-2">
                                        <input type="text" id="name" v-model="form.name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.name" class="mt-2 text-sm text-red-600">{{ errors.name[0] }}</p>
                                    </div>
                                </div>
                                <!-- Position -->
                                <div class="sm:col-span-2">
                                    <label for="position" class="block text-sm font-medium leading-6 text-gray-900">Position</label>
                                    <div class="mt-2">
                                        <input type="position" id="position" v-model="form.position" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.position" class="mt-2 text-sm text-red-600">{{ errors.position[0] }}</p>
                                    </div>
                                </div>

                                <!-- Branch -->
                                <div class="sm:col-span-6">
                                    <label for="branch" class="block text-sm font-medium leading-6 text-gray-900">Branch</label>
                                    <div class="mt-2">
                                        <select id="branch" v-model="form.branch" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="Main Office">Main Office - Unit 2004, Perla Mansion, C. Palanca St., Legaspi Village, Makati City, Metro Manila</option>
                                            <option value="JB Guadalupe">JB Guadalupe - Princess Bldg. 2, Ground Floor, Guadalupe Nuevo, Makati City, Metro Manila</option>
                                            <option value="Robinsons Galleria">Robinsons Galleria - Lower Ground near SSS Office, Robinsons Galleria, Ortigas Ave., Ortigas Center, Quezon City, Metro Manila</option>
                                            <option value="Unimart">Unimart - Unimart Greenhills Shopping Center, San Juan City, Metro Manila</option>
                                            <option value="Market Market 1">Market Market 1 - 2nd Floor, Fashion Market, Market! Market!, McKinley Pkwy, Taguig, Metro Manila</option>
                                            <option value="Market Market 3">Market Market 3 - 2nd Floor near Cebuana Lhuilier, Market! Market!, McKinley Pkwy, Taguig, Metro Manila</option>
                                            <option value="Makati Ave.">Makati Ave. - A&W Bldg, Makati Ave, Poblacion, Bel Air, Makati City, Metro Manila</option>
                                            <option value="Cash and Carry">Cash and Carry - Ground Floor, Cash and Carry Mall, Filmore & Emilia St., Palanan, Makati City, Metro Manila</option>
                                            <option value="The Link">The Link - 2nd Floor, The Link, Makati Ave., Bel Air, Makati City cor. Parkway Dr., San Lorenzo, Makati City, Metro Manila</option>
                                            <option value="Glorietta 1">Glorietta 1 - Basement 1, Glorietta 1, Hotel Drive, San Lorenzo, Makati City, Metro Manila</option>
                                            <option value="One Ayala">One Ayala - Lower Ground, One Ayala, Ayala Avenue cor. EDSA, San Lorenzo, Makati City, Metro Manila</option>
                                        </select>
                                        <p v-if="errors.branch" class="mt-2 text-sm text-red-600">{{ errors.branch[0] }}</p>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="sm:col-span-4">
                                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                                    <div class="mt-2">
                                        <input id="email" type="email" v-model="form.email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.email" class="mt-2 text-sm text-red-600">{{ errors.email[0] }}</p>
                                    </div>
                                </div>
                                <!-- Role -->
                                <div class="sm:col-span-2">
                                    <label for="role" class="block text-sm font-medium leading-6 text-gray-900">Role</label>
                                    <div class="mt-2">
                                        <select id="role" v-model="form.role" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="administrator">Administrator</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                        <p v-if="errors.role" class="mt-2 text-sm text-red-600">{{ errors.role[0] }}</p>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="sm:col-span-4">
                                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                    <div class="mt-2">
                                        <input id="password" type="password" v-model="form.password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.password" class="mt-2 text-sm text-red-600">{{ errors.password[0] }}</p>
                                    </div>
                                </div>

                                <!-- Age -->
                                <div class="sm:col-span-2">
                                    <label for="age" class="block text-sm font-medium leading-6 text-gray-900">Age</label>
                                    <div class="mt-2">
                                        <input type="number" id="age" v-model="form.age" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.age" class="mt-2 text-sm text-red-600">{{ errors.age[0] }}</p>
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="sm:col-span-4">
                                    <label for="contact_number" class="block text-sm font-medium leading-6 text-gray-900">Contact Number</label>
                                    <div class="mt-2">
                                        <input type="text" id="contact_number" v-model="form.contact_number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.contact_number" class="mt-2 text-sm text-red-600">{{ errors.contact_number[0] }}</p>
                                    </div>
                                </div>

                                <!-- Sex -->
                                <div class="sm:col-span-2">
                                    <label for="sex" class="block text-sm font-medium leading-6 text-gray-900">Sex</label>
                                    <div class="mt-2">
                                        <select id="sex" v-model="form.sex" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <p v-if="errors.sex" class="mt-2 text-sm text-red-600">{{ errors.sex[0] }}</p>
                                    </div>
                                </div>

                                <!-- Civil Status -->
                                <div class="sm:col-span-2">
                                    <label for="civil_status" class="block text-sm font-medium leading-6 text-gray-900">Civil Status</label>
                                    <div class="mt-2">
                                        <select id="civil_status" v-model="form.civil_status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                        <p v-if="errors.civil_status" class="mt-2 text-sm text-red-600">{{ errors.civil_status[0] }}</p>
                                    </div>
                                </div>

                                <!-- Citizenship -->
                                <div class="sm:col-span-3">
                                    <label for="citizenship" class="block text-sm font-medium leading-6 text-gray-900">Citizenship</label>
                                    <div class="mt-2">
                                        <input type="text" id="citizenship" v-model="form.citizenship" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.citizenship" class="mt-2 text-sm text-red-600">{{ errors.citizenship[0] }}</p>
                                    </div>
                                </div>

                                <!-- Religion -->
                                <div class="sm:col-span-3">
                                    <label for="religion" class="block text-sm font-medium leading-6 text-gray-900">Religion</label>
                                    <div class="mt-2">
                                        <input type="text" id="religion" v-model="form.religion" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.religion" class="mt-2 text-sm text-red-600">{{ errors.religion[0] }}</p>
                                    </div>
                                </div>

                                <!-- Weight -->
                                <div class="sm:col-span-2">
                                    <label for="weight" class="block text-sm font-medium leading-6 text-gray-900">Weight (kg)</label>
                                    <div class="mt-2">
                                        <input type="number" step="0.1" id="weight" v-model="form.weight" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.weight" class="mt-2 text-sm text-red-600">{{ errors.weight[0] }}</p>
                                    </div>
                                </div>

                                <!-- Height -->
                                <div class="sm:col-span-2">
                                    <label for="height" class="block text-sm font-medium leading-6 text-gray-900">Height (cm)</label>
                                    <div class="mt-2">
                                        <input type="number" step="0.1" id="height" v-model="form.height" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.height" class="mt-2 text-sm text-red-600">{{ errors.height[0] }}</p>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="sm:col-span-3">
                                    <label for="date_of_birth" class="block text-sm font-medium leading-6 text-gray-900">Date of Birth</label>
                                    <div class="mt-2">
                                        <input type="date" id="date_of_birth" v-model="form.date_of_birth" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.date_of_birth" class="mt-2 text-sm text-red-600">{{ errors.date_of_birth[0] }}</p>
                                    </div>
                                </div>

                                <!-- Place of Birth -->
                                <div class="sm:col-span-3">
                                    <label for="place_of_birth" class="block text-sm font-medium leading-6 text-gray-900">Place of Birth</label>
                                    <div class="mt-2">
                                        <input type="text" id="place_of_birth" v-model="form.place_of_birth" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.place_of_birth" class="mt-2 text-sm text-red-600">{{ errors.place_of_birth[0] }}</p>
                                    </div>
                                </div>

                                <!-- Present Address -->
                                <div class="col-span-full">
                                    <label for="present_address" class="block text-sm font-medium leading-6 text-gray-900">Present Address</label>
                                    <div class="mt-2">
                                        <input type="text" id="present_address" v-model="form.present_address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.present_address" class="mt-2 text-sm text-red-600">{{ errors.present_address[0] }}</p>
                                    </div>
                                </div>

                                <!-- Permanent Address -->
                                <div class="col-span-full">
                                    <label for="permanent_address" class="block text-sm font-medium leading-6 text-gray-900">Permanent Address</label>
                                    <div class="mt-2">
                                        <input type="text" id="permanent_address" v-model="form.permanent_address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <p v-if="errors.permanent_address" class="mt-2 text-sm text-red-600">{{ errors.permanent_address[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Skills and Other Qualifications:</label>
                        <div v-for="(skill, index) in form.skills" :key="index" class="mb-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <input
                                    v-model="skill.skill_name"
                                    placeholder="Skill Name"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="skill.proficiency_level"
                                    placeholder="Proficiency Level"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="skill.description"
                                    placeholder="Description"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                            <button
                                type="button"
                                @click="removeSkill(index)"
                                class="mt-2 w-full md:w-auto px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                            >
                                Remove Skill
                            </button>
                        </div>
                        <button
                            type="button"
                            @click="addSkill"
                            class="w-full md:w-auto px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        >
                            Add Skill
                        </button>
                    </div>

                    <!-- Educational Background -->
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Educational Background:</label>
                        <div class="space-y-4">
                            <div class="rounded-lg">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">College</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <input
                                        v-model="form.educational_background.college"
                                        placeholder="College"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                    <input
                                        v-model="form.educational_background.college_course"
                                        placeholder="College Course"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                    <input
                                        v-model="form.educational_background.college_school_year"
                                        placeholder="College School Year"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                            <div class=" rounded-lg">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Secondary</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <input
                                        v-model="form.educational_background.secondary"
                                        placeholder="Secondary School"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                    <input
                                        v-model="form.educational_background.secondary_course"
                                        placeholder="Secondary Course"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                    <input
                                        v-model="form.educational_background.secondary_school_year"
                                        placeholder="Secondary School Year"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                            <div class=" rounded-lg">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Elementary</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <input
                                        v-model="form.educational_background.elementary"
                                        placeholder="Elementary School"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                    <input
                                        v-model="form.educational_background.elementary_course"
                                        placeholder="Elementary Course"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                    <input
                                        v-model="form.educational_background.elementary_school_year"
                                        placeholder="Elementary School Year"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Employment Records -->
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Previous Employment Records:</label>
                        <div v-for="(record, index) in form.previous_employment_records" :key="index" class="mb-4  rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input
                                    v-model="record.company_name"
                                    placeholder="Company Name"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="record.position"
                                    placeholder="Position"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="record.date_employed"
                                    type="date"
                                    placeholder="Date Employed"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="record.salary"
                                    placeholder="Salary"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="record.reason_of_leaving"
                                    placeholder="Reason of Leaving"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                            <button
                                type="button"
                                @click="removeEmploymentRecord(index)"
                                class="mt-2 w-full md:w-auto px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                            >
                                Remove Record
                            </button>
                        </div>
                        <button
                            type="button"
                            @click="addEmploymentRecord"
                            class="w-full md:w-auto px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        >
                            Add Employment Record
                        </button>
                    </div>

                    <!-- References -->
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">References:</label>
                        <div v-for="(reference, index) in form.references" :key="index" class="mb-4  rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input
                                    v-model="reference.name"
                                    placeholder="Name"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="reference.contact"
                                    placeholder="Contact"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="reference.occupation"
                                    placeholder="Occupation"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="reference.relation"
                                    placeholder="Relation"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                            <button
                                type="button"
                                @click="removeReference(index)"
                                class="mt-2 w-full md:w-auto px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                            >
                                Remove Reference
                            </button>
                        </div>
                        <button
                            type="button"
                            @click="addReference"
                            class="w-full md:w-auto px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        >
                            Add Reference
                        </button>
                    </div>

                    <!-- Emergency Contacts -->
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contacts:</label>
                        <div v-for="(contact, index) in form.emergency_contacts" :key="index" class="mb-4  rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input
                                    v-model="contact.name"
                                    placeholder="Name"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="contact.address"
                                    placeholder="Address"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="contact.contact"
                                    placeholder="Contact"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <input
                                    v-model="contact.relation"
                                    placeholder="Relation"
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                            <button
                                type="button"
                                @click="removeEmergencyContact(index)"
                                class="mt-2 w-full md:w-auto px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                            >
                                Remove Contact
                            </button>
                        </div>
                        <button
                            type="button"
                            @click="addEmergencyContact"
                            class="w-full md:w-auto px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        >
                            Add Emergency Contact
                        </button>
                    </div>

                    <!-- Government Benefits -->
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Government Benefits:</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input
                                v-model="form.government_benefits.sss_no"
                                placeholder="SSS No"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <input
                                v-model="form.government_benefits.pag_ibig_no"
                                placeholder="Pag-IBIG No"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <input
                                v-model="form.government_benefits.philhealth_no"
                                placeholder="PhilHealth No"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <input
                                v-model="form.government_benefits.tin_no"
                                placeholder="TIN No"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <input
                                v-model="form.government_benefits.employee_no"
                                placeholder="Employee No"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                    </div>
                    <div class="mb-6 border-b py-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Employed:</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <input
                                v-model="form.government_benefits.date_employed"
                                type="date"
                                placeholder="Date Employed"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast(); // Initialize toast

// Reactive state for form data
const form = ref({
    // User details
    name: '',
    email: '',
    role: '',
    password: '',
    profile_picture: null,

    // Profile details
    position: '',
    branch: '',
    age: '',
    contact_number: '',
    sex: '',
    civil_status: '',
    citizenship: '',
    religion: '',
    weight: '',
    height: '',
    date_of_birth: '',
    place_of_birth: '',
    present_address: '',
    permanent_address: '',

    // Skills (array of objects)
    skills: [
        {
            skill_name: '',
            proficiency_level: '',
            description: '',
        }
    ],

    // Educational Background (single object)
    educational_background: {
        college: '',
        college_course: '',
        college_school_year: '',
        secondary: '',
        secondary_course: '',
        secondary_school_year: '',
        elementary: '',
        elementary_course: '',
        elementary_school_year: '',
    },

    // Previous Employment Records (array of objects)
    previous_employment_records: [
        {
            company_name: '',
            position: '',
            date_employed: '',
            salary: '',
            reason_of_leaving: '',
        }
    ],

    // References (array of objects)
    references: [
        {
            name: '',
            contact: '',
            occupation: '',
            relation: '',
        }
    ],

    // Emergency Contacts (array of objects)
    emergency_contacts: [
        {
            name: '',
            address: '',
            contact: '',
            relation: '',
        }
    ],

    // Government Benefits (single object)
    government_benefits: {
        sss_no: '',
        pag_ibig_no: '',
        philhealth_no: '',
        tin_no: '',
        employee_no: '',
        date_employed: '',
    },
});

const previewProfilePicture = ref('');
const fileInput = ref(null); // Create a ref for the file input

// Function to handle file upload
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.value.profile_picture = file;
        previewProfilePicture.value = URL.createObjectURL(file);
    }
};

// Function to trigger file selection
const openFilePicker = () => {
    fileInput.value.click();
};

// Reactive state for form errors
const errors = ref({});

const addSkill = () => {
    form.value.skills.push({
        skill_name: '',
        proficiency_level: '',
        description: '',
    });
};

const removeSkill = (index) => {
    form.value.skills.splice(index, 1);
};

const addEmploymentRecord = () => {
    form.value.previous_employment_records.push({
        company_name: '',
        position: '',
        date_employed: '',
        salary: '',
        reason_of_leaving: '',
    });
};

const removeEmploymentRecord = (index) => {
    form.value.previous_employment_records.splice(index, 1);
};

const addReference = () => {
    form.value.references.push({
        name: '',
        contact: '',
        occupation: '',
        relation: '',
    });
};

const removeReference = (index) => {
    form.value.references.splice(index, 1);
};

const addEmergencyContact = () => {
    form.value.emergency_contacts.push({
        name: '',
        address: '',
        contact: '',
        relation: '',
    });
};

const removeEmergencyContact = (index) => {
    form.value.emergency_contacts.splice(index, 1);
};

const submitForm = async () => {
    try {
        const formData = new FormData();

        // Append user and profile details
        for (const key in form.value) {
            if (key === 'skills' || key === 'previous_employment_records' || key === 'references' || key === 'emergency_contacts' || key === 'educational_background' || key === 'government_benefits') {
                continue; // Skip nested objects/arrays for now
            }
            formData.append(key, form.value[key]);
        }

        // Append profile picture
        if (form.value.profile_picture) {
            formData.append('profile_picture', form.value.profile_picture);
        }

        // Append skills
        form.value.skills.forEach((skill, index) => {
            formData.append(`skills[${index}][skill_name]`, skill.skill_name);
            formData.append(`skills[${index}][proficiency_level]`, skill.proficiency_level);
            formData.append(`skills[${index}][description]`, skill.description);
        });

        // Append educational background
        for (const key in form.value.educational_background) {
            formData.append(`educational_background[${key}]`, form.value.educational_background[key]);
        }

        // Append previous employment records
        form.value.previous_employment_records.forEach((record, index) => {
            formData.append(`previous_employment_records[${index}][company_name]`, record.company_name);
            formData.append(`previous_employment_records[${index}][position]`, record.position);
            formData.append(`previous_employment_records[${index}][date_employed]`, record.date_employed);
            formData.append(`previous_employment_records[${index}][salary]`, record.salary);
            formData.append(`previous_employment_records[${index}][reason_of_leaving]`, record.reason_of_leaving);
        });

        // Append references
        form.value.references.forEach((reference, index) => {
            formData.append(`references[${index}][name]`, reference.name);
            formData.append(`references[${index}][contact]`, reference.contact);
            formData.append(`references[${index}][occupation]`, reference.occupation);
            formData.append(`references[${index}][relation]`, reference.relation);
        });

        // Append emergency contacts
        form.value.emergency_contacts.forEach((contact, index) => {
            formData.append(`emergency_contacts[${index}][name]`, contact.name);
            formData.append(`emergency_contacts[${index}][address]`, contact.address);
            formData.append(`emergency_contacts[${index}][contact]`, contact.contact);
            formData.append(`emergency_contacts[${index}][relation]`, contact.relation);
        });

        // Append government benefits
        for (const key in form.value.government_benefits) {
            formData.append(`government_benefits[${key}]`, form.value.government_benefits[key]);
        }

        // Send the request
        const response = await axios.post('/api/employees', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        if (response.status === 201) {
            // Show success toast
            toast.success('Employee created successfully!');

            // Redirect after 3 seconds
            setTimeout(() => {
                window.location.href = route('employee.index');
            }, 3000);
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
            console.error('Validation errors:', errors.value);

            // Show validation error toasts
            for (const field in errors.value) {
                toast.error(`${field}: ${errors.value[field].join(', ')}`);
            }
        } else {
            // Show generic error toast
            toast.error('An error occurred. Please try again.');
            console.error('Error:', error);
        }
    }
};
</script>

