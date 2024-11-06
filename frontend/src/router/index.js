import { createRouter, createWebHistory } from 'vue-router';
import store from '../store/index.js';
import Curriculo from '../views/CurriculoCandidato.vue';
import HomeCandidato from '../views/HomeCandidato.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import RegisterEmpresa from '../views/RegisterEmpresa.vue';
import PerfilCandidato from '../views/PerfilCandidato.vue';
import HomeEmpresa from '../views/HomeEmpresa.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home-candidato',
      name: 'home-candidato',
      component: HomeCandidato,
      meta: {
        title: 'Home',
        requiresAuth: true,
      },
    },
    {
      path: '/curriculo',
      name: 'curriculo',
      component: Curriculo,
      meta: {
        title: 'Currículo',
        requiresAuth: true,
      },
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        title: 'Login',
        requiresAuth: false,
      },
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: {
        title: 'Register',
      },
    },
    {
      path: '/register-empresa',
      name: 'register-empresa',
      component: RegisterEmpresa,
      meta: {
        title: 'Register Empresa',
      },
    },
    {
      path: '/meu-perfil',
      name: 'perfil-candidato',
      component: PerfilCandidato,
      meta: {
        title: 'Meu Perfil',
        requiresAuth: true,
      },
    },
    {
      path: '/home-empresa',
      name: 'home-empresa',
      component: HomeEmpresa,
      meta: {
        title: 'Empresa',
        requiresAuth: true,
      },
    },
  ],
});



router.beforeEach((to, from, next) => {
  document.title = to.meta.title;

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.getters.isAuthenticated) {
      return next({ name: 'login' });
    }
  }

  if (to.matched.some(record => !record.meta.requiresAuth)) {
    if (store.getters.isAuthenticated) {
      return next({ name: 'home-candidato' });
    }
  }

  next();
});




export default router;
