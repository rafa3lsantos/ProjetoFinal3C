import { createRouter, createWebHistory } from 'vue-router';
import Curriculo from '../views/CurriculoCandidato.vue';
import HomeCandidato from '../views/HomeCandidato.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import RegisterEmpresa from '../views/RegisterEmpresa.vue';
import DadosPessoais from '../views/DadosPessoais.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home-candidato',
      name: 'home-candidato',
      component: HomeCandidato,
      meta: {
        title: 'Home'
      }
    },
    {
      path: '/curriculo',
      name: 'curriculo',
      component: Curriculo,
      meta: {
        title: 'curriculo'
      }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        title: 'login'
      }
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: {
        title: 'register'
      }
    },
    {
      path: '/register-empresa',
      name: 'register-empresa',
      component: RegisterEmpresa,
      meta: {
        title: 'register-empresa'
      }
    },
    {
      path: '/dados-pessoais',
      name: 'dados pessoais',
      component: DadosPessoais,
      meta: {
        title: 'Dados Pessoais'
      }
    }


  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router;
