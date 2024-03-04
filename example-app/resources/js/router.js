import { createRouter, createWebHashHistory } from 'vue-router';

// const checkAuth = () => {
//   const token = localStorage.getItem('user_token');
//   return Boolean(token);
// };

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
      path: '/home',
      component: () => import('./components/Home.vue'),
      name: 'Home',
    },
    ],
});

export default router