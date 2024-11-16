<template>
    <div class="logout-page">
        <p v-if="loading">Logging out...</p>
        <p v-else-if="error" class="text-red-500">{{ error }}</p>
        <p v-else class="text-green-500">{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: true,
            error: null,
            message: null
        };
    },
    async created() {
        try {
            const response = await fetch('/api/v1/logout', {
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Logout failed');
            }

            const data = await response.json();
            this.message = data.message;

            this.$store.commit('setAuthToken', null);

            setTimeout(() => {
                this.$router.push('/login');
            }, 2000);
        } catch (err) {
            this.error = err.message;
        } finally {
            this.loading = false;
        }
    }
};
</script>
