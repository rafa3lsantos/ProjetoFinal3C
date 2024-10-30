import { createRouter, createWebHistory } from 'vue-router';
import Perfil from '../views/PerfilCandidato.vue';
import Home from '../views/Home.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      meta: {
        title: 'Home'
      }
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: Perfil,
      meta: {
        title: 'Perfil'
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router;
