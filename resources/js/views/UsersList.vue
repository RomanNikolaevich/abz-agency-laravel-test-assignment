<template>
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">Users List</h1>
        <div v-if="error" class="text-red-500 font-bold">
            <p>{{ error }}</p>
        </div>
        <div v-else-if="users.length === 0" class="italic text-gray-500">
            <p>No users found</p>
        </div>
        <div v-else>
            <ul class="divide-y divide-gray-100">
                <li v-for="user in users" :key="user.id" class="flex justify-between gap-x-6 py-5">
                    <div class="flex min-w-0 gap-x-4">
                        <img
                            v-if="user.photo"
                            :src="user.photo"
                            alt="Profile avatar"
                            class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        />
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold text-gray-900">{{ user.name }}</p>
                            <p class="mt-1 truncate text-xs text-gray-500">{{ user.email }}</p>
                            <p class="mt-1 truncate text-xs text-gray-500">Reg. id: {{ user.id }}</p>
                        </div>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm/6 text-gray-900">{{ user.position }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ user.phone }}</p>
                        <p class="mt-1 text-xs text-gray-500">
                            Date of registration: {{ formatDate(user.registration_timestamp) }}
                        </p>
                    </div>

                </li>
            </ul>

            <div class="flex justify-left mt-4">
                <button v-if="nextPageUrl"
                        @click="fetchUsers(nextPageUrl)"
                        class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                >
                    Show more
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {ref, onMounted} from 'vue';

export default {
    name: 'UsersList',
    setup() {
        const users = ref([]);
        const error = ref(null);
        const nextPageUrl = ref(null);

        const fetchUsers = async (url = '/api/v1/users') => {
            try {
                const response = await axios.get(url, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });

                if (!users.value.length) {
                    users.value = response.data.users;
                } else {
                    users.value.push(...response.data.users);
                }

                nextPageUrl.value = response.data.links.next_link;
                error.value = null;
            } catch (err) {
                if (err.response && err.response.status === 401) {
                    error.value = 'Unauthorized access. Please log in again.';
                } else {
                    error.value = 'Failed to load users. Please try again later.';
                }
                console.error('Error fetching users:', err);
            }
        };

        const formatDate = (timestamp) => {
            const date = new Date(timestamp * 1000);
            return date.toLocaleDateString();
        };

        onMounted(() => {
            fetchUsers();
        });

        return {
            users,
            error,
            nextPageUrl,
            fetchUsers,
            formatDate
        };
    }
};
</script>
