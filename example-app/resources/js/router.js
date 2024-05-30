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
    {
      path: '/storage',
      component: () => import('./components/Admin/Storage.vue'),
      name: 'Storage',
      meta: { requiresAuth: true },
    },
    {
      path: '/products',
      component: () => import('./components/Admin/Products.vue'),
      name: 'Products',
      meta: { requiresAuth: true },
    },
    {
      path: '/orders',
      component: () => import('./components/Admin/Orders.vue'),
      name: 'Orders',
      meta: { requiresAuth: true },
    },
    {
      path: '/reports',
      component: () => import('./components/Admin/Reports.vue'),
      name: 'Reports',
      meta: { requiresAuth: true },
    },
    {
      path: '/manufacturer',
      component: () => import('./components/Admin/Manufacturer.vue'),
      name: 'Manufacturer',
      meta: { requiresAuth: true },
    },
  ],
});

router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = store.state.isAuthenticated;

  if (!isAuthenticated && to.path !== '/register' && to.path !== '/login') {
    next('/register');
  } else if (requiresAuth && !isAuthenticated) {
    next('/login');
  } else {
    next();
  }
});

export default router;