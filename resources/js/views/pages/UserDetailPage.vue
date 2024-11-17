<template>
    <div class="px-4 sm:px-0">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">User Detail</h1>

        <div v-if="error" class="text-red-500 font-bold">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="!user" class="italic text-gray-500">
            <p>Loading user data...</p>
        </div>

        <div v-else>
            <img
                v-if="user.photo"
                :src="user.photo"
                alt="Profile avatar"
                class="h-12 w-12 flex-none rounded-full bg-gray-50"
            />
            <div class="mt-6 border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">Full name</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.name }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">User ID</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.id }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">Position for</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.position }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">Position ID</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.position_id }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">Email address</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.email }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">Phone</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.phone }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900">Date of registration</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ formatDate(user.registration_timestamp) }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="flex justify-left mt-4">
            <router-link :to="`/users`">
                <button
                    class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    Back to users list
                </button>
            </router-link>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'UserDetailPage',
    props: ['id'],
    data() {
        return {
            user: null,
            error: null
        };
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get(`/api/v1/users/${this.id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.user = response.data.user;
                this.error = null;
            } catch (err) {
                this.error = 'Failed to load user data. Receive a new token for further access.';
                console.error('Error fetching user:', err);
            }
        },
        formatDate(timestamp) {
            const date = new Date(timestamp * 1000);
            return date.toLocaleDateString();
        }
    },
    mounted() {
        this.fetchUser();
    }
};
</script>
