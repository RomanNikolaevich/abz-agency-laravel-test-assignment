import { createStore } from 'vuex';

export default createStore({
    state: {
        authToken: null,
        users: [],
        currentUser: null
    },
    mutations: {
        setAuthToken(state, token) {
            state.authToken = token;
        },
        setUsers(state, users) {
            state.users = users;
        },
        setCurrentUser(state, user) {
            state.currentUser = user;
        }
    },
    actions: {
        async fetchUsers({ commit }) {
            const response = await fetch('/api/v1/users');
            const data = await response.json();
            commit('setUsers', data);
        }
    },
    modules: {}
});
