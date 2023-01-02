import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'

import { useCommonStore } from "../stores/index";

const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            requiresAuth: true,
        } 
    },
    
    { path: '/login', component: Login },
]

const router = createRouter({ history: createWebHistory(), routes })


router.beforeEach((to, from, next) => {
    const common = useCommonStore();

	if (!to.matched.some(record => record.meta.requiresAuth)) {
		next();
		return;
	}
	if (!common.isLoggedIn) {
		next("/login");
		return;
	}
    next()
})

export default router;