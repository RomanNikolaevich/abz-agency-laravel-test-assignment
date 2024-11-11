import { createRouter, createWebHistory } from 'vue-router';
import UserLogin from '../views/UserLogin.vue';
import UserRegister from '../views/UserRegister.vue';
import UsersList from '../views/UsersList.vue';
import UserDetail from '../views/UserDetail.vue';

const routes = [
    { path: '/', redirect: '/login' },
    { path: '/login', component: UserLogin },
    { path: '/register', component: UserRegister },
    { path: '/users', component: UsersList },
    { path: '/users/:id', component: UserDetail, props: true }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
