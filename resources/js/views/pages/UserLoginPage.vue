<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-20 w-auto rounded-full"
                 src="https://avatars.githubusercontent.com/u/85992849?s=400&u=8210effa13dd93ccd0865887b2002cf43476f51a&v=4"
                 alt="My Github avatar">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="handleLogin" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input v-model="email" id="email" name="email" type="email" autocomplete="email" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="password" id="password" name="password" type="password"
                               autocomplete="current-password" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Are you a new user?
                <router-link to="/register" class="font-semibold text-indigo-600 hover:text-indigo-500">Please
                    register
                </router-link>
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {ref} from 'vue';
import {useRouter} from 'vue-router';

export default {
    name: 'UserLoginPage',
    setup() {
        const email = ref('');
        const password = ref('');
        const router = useRouter();

        const handleLogin = async () => {
            try {
                const response = await axios.post('/api/v1/login', {
                    email: email.value,
                    password: password.value,
                });

                const token = response.data.token;
                localStorage.setItem('token', token);

                router.push('/users');
            } catch (error) {
                console.error('Login failed', error.response ? error.response.data : error);
                alert(error.response?.data?.error || 'Invalid credentials or an error occurred');
            }
        };

        return {
            email,
            password,
            handleLogin,
        };
    },
};
</script>
