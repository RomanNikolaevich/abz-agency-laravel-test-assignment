<template>
    <div id="app">
        <Header v-if="isAuthenticated" />
        <router-view></router-view>
    </div>
</template>

<script>
import Header from './views/components/Header.vue';
export default {
    name: 'App',
    components: {
        Header
    },
    computed: {
        isAuthenticated() {
            return this.$store.state.authToken !== null;
        }
    }
}
</script>
