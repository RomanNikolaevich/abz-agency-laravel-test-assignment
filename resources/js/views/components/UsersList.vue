<template>
    <div v-if="error" class="text-red-500 font-bold">
        <p>{{ error }}</p>
    </div>
    <div v-else-if="users.length === 0" class="italic text-gray-500">
        <p>No users found</p>
    </div>
    <div v-else>
        <div class="mb-4">
            <label for="user-count" class="block text-sm font-medium text-gray-700">Users per page:</label>
            <input
                type="number"
                id="user-count"
                v-model="userCount"
                @change="handleCountChange"
                min="1"
                class="mt-2 w-20 h-8 p-1 border border-gray-300 rounded-md"
            />
        </div>

        <div class="mb-4">
            <label for="page-number" class="block text-sm font-medium text-gray-700">Page number:</label>
            <input
                type="number"
                id="page-number"
                v-model="pageCount"
                @change="handlePageChange"
                min="1"
                class="mt-2 w-20 h-8 p-1 border border-gray-300 rounded-md"
            />
        </div>

        <ul class="divide-y divide-gray-100">
            <li v-for="user in users" :key="user.id" class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <router-link :to="`/users/${user.id}`">
                        <img
                            v-if="user.photo"
                            :src="user.photo"
                            alt="Profile avatar"
                            class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        />
                    </router-link>
                    <div class="min-w-0 flex-auto">
                        <router-link :to="`/users/${user.id}`">
                            <p class="text-sm font-semibold text-gray-900">{{ user.name }}</p>
                        </router-link>
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
                    @click="loadMore"
                    class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            >
                Show more
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {ref, onMounted} from 'vue';

const API_USERS_URL = '/api/v1/users';

export default {
    name: 'UsersList',
    setup() {
        const users = ref([]);
        const error = ref(null);
        const nextPageUrl = ref(null);
        const userCount = ref(6);
        const pageCount = ref(1);

        const fetchUsers = async (url = API_USERS_URL, reset = false) => {
            try {
                const response = await axios.get(url, {
                    params: {
                        count: userCount.value,
                        page: pageCount.value,
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });

                if (reset) {
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

        const handleCountChange = () => {
            pageCount.value = 1;
            fetchUsers(API_USERS_URL, true);
        };

        const handlePageChange = () => {
            fetchUsers(API_USERS_URL, true);
        };

        const loadMore = () => {
            pageCount.value += 1;
            fetchUsers(nextPageUrl.value);
        };

        onMounted(() => {
            fetchUsers();
        });

        return {
            users,
            error,
            nextPageUrl,
            userCount,
            pageCount,
            fetchUsers,
            formatDate,
            handleCountChange,
            handlePageChange,
            loadMore
        };
    }
};
</script>
