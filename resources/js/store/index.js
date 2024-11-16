import { createStore } from 'vuex';

export default createStore({
    state: {
        authToken: localStorage.getItem('token') || null,
        users: [],
        currentUser: null
    },
    mutations: {
        setAuthToken(state, token) {
            state.authToken = token;
            if (token) {
                localStorage.setItem('token', token);
            } else {
                localStorage.removeItem('token');
            }
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
        },
        async logout({ commit }) {
            commit('setAuthToken', null);
            commit('setCurrentUser', null);
        }
    },
    modules: {}
});
