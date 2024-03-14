import { createRouter, createWebHashHistory } from 'vue-router';
import store from './store';

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/login',
      component: () => import('./components/Login.vue'),
      name: 'Login',
    },
    {
      path: '/register',
      component: () => import('./components/Register.vue'),
      name: 'Register',
    },
    {
      path: '/admin-home',
      component: () => import('./components/Admin/AdminHome.vue'),
      name: 'AdminHome',
      meta: { requiresAuth: true },
    },
    {
      path: '/worker-home',
      component: () => import('./components/Worker/WorkerHome.vue'),
      name: 'WorkerHome',
      meta: { requiresAuth: true },
    },
    {
      path: '/organizer-home',
      component: () => import('./components/Organizer/OrganizerHome.vue'),
      name: 'OrganizerHome',
      meta: { requiresAuth: true },
    },
  ],
});

router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = store.state.isAuthenticated;

  if (requiresAuth && !isAuthenticated) {
      next({ name: 'Login', query: { redirect: to.fullPath } });
  } else {
      next();
  }
});

export default router