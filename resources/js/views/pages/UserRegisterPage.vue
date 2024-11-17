<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-20 w-auto rounded-full"
                 src="https://avatars.githubusercontent.com/u/85992849?s=400&u=8210effa13dd93ccd0865887b2002cf43476f51a&v=4"
                 alt="My Github avatar">
            <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">Register an account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="handleRegister" class="space-y-6" enctype="multipart/form-data">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900">Full Name</label>
                    <div class="mt-2">
                        <input v-model="form.name" id="name" name="name" type="text" required
                               class="block w-full rounded-md border-gray-300 py-1.5 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                    </div>
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                    <div class="mt-2">
                        <input v-model="form.email" id="email" name="email" type="email" required
                               class="block w-full rounded-md border-gray-300 py-1.5 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                    </div>
                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-900">Phone</label>
                    <div class="mt-2">
                        <input v-model="form.phone" id="phone" name="phone" type="tel" placeholder="+380123456789"
                               required
                               class="block w-full rounded-md border-gray-300 py-1.5 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                    </div>
                    <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <div class="mt-2">
                        <input v-model="form.password" id="password" name="password" type="password" required
                               class="block w-full rounded-md border-gray-300 py-1.5 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                    </div>
                    <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
                </div>

                <!-- Position List -->
                <div>
                    <PositionsList v-model:positionId="form.position_id"/>
                    <p v-if="errors.position_id" class="mt-1 text-sm text-red-600">{{ errors.position_id }}</p>
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-900">Photo</label>
                    <div class="mt-2">
                        <input @change="handleFileUpload" id="photo" name="photo" type="file" accept="image/jpeg"
                               class="block w-full text-sm text-gray-900 border-gray-300 rounded-md focus:ring-indigo-600 focus:border-indigo-600">
                    </div>
                    <p v-if="errors.photo" class="mt-1 text-sm text-red-600">{{ errors.photo }}</p>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-indigo-600">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {ref} from 'vue';
import {useRouter} from 'vue-router';
import PositionsList from '../components/PositionsList.vue';
import {useStore} from "vuex";

export default {
    name: 'UserRegisterPage',
    components: {PositionsList},
    setup() {
        const router = useRouter();
        const store = useStore();
        const form = ref({
            name: '',
            email: '',
            phone: '',
            password: '',
            position_id: '',
            photo: null,
        });
        const errors = ref({});
        const successMessage = ref('');

        const handleRegister = async () => {
            try {
                const formData = new FormData();
                formData.append('name', form.value.name);
                formData.append('email', form.value.email);
                formData.append('phone', form.value.phone);
                formData.append('password', form.value.password);
                formData.append('position_id', form.value.position_id);
                formData.append('photo', form.value.photo);

                const response = await axios.post('/api/v1/users', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                const token = response.data.token;
                store.commit('setAuthToken', token);

                if (response.data.success) {
                    successMessage.value = 'Registration successful!';
                    router.push('/users');  // Redirect to users page after successful registration
                }
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    errors.value = error.response.data.errors;
                }
            }
        };

        const handleFileUpload = (event) => {
            form.value.photo = event.target.files[0];
        };

        return {
            form,
            errors,
            handleRegister,
            handleFileUpload,
            successMessage,
        };
    },
};
</script>
