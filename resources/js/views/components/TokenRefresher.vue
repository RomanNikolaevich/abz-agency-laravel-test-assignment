<template>
    <div class="flex flex-col justify-left mt-4">
        <button
            @click="refreshToken"
            :disabled="loading"
            class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        >
            {{ loading ? "Refreshing..." : "Refresh Token" }}
        </button>
        <p v-if="newToken" class="text-green-500 mt-4">
            New token: <strong>{{ newToken }}</strong>
        </p>
        <p v-if="errorMessage" class="text-red-500 mt-4">
            {{ errorMessage }}
        </p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "TokenRefresher",
    data() {
        return {
            loading: false,
            newToken: null,
            errorMessage: null,
        };
    },
    methods: {
        async refreshToken() {
            this.loading = true;
            this.newToken = null;
            this.errorMessage = null;

            try {
                const response = await axios.get("/api/v1/token", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                });
                if (response.data.success) {
                    this.newToken = response.data.token;
                    localStorage.setItem("token", this.newToken); // Обновляем токен в localStorage
                }
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || "Failed to refresh token.";
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<!--<style scoped>-->
<!--.token-refresher button:disabled {-->
<!--    cursor: not-allowed;-->
<!--    opacity: 0.5;-->
<!--}-->
<!--</style>-->
