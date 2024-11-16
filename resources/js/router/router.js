import { createRouter, createWebHistory } from 'vue-router';
import UserLoginPage from '../views/pages/UserLoginPage.vue';
import UserRegisterPage from '../views/pages/UserRegisterPage.vue';
import UsersPage from '../views/pages/UsersPage.vue';
import UserDetailPage from '../views/pages/UserDetailPage.vue';
import PositionsList from '../views/components/PositionsList.vue';

const routes = [
    { path: '/', redirect: '/login' },
    { path: '/login', component: UserLoginPage },
    { path: '/register', component: UserRegisterPage },
    { path: '/users', component: UsersPage },
    { path: '/users/:id', component: UserDetailPage, props: true },
    { path: '/positions', component: PositionsList }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
