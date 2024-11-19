import { createRouter, createWebHistory } from 'vue-router';
import store from '../store/index.js';
import Curriculo from '../views/CurriculoCandidato.vue';
import HomeCandidato from '../views/HomeCandidato.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import RegisterEmpresa from '../views/RegisterEmpresa.vue';
import PerfilCandidato from '../views/PerfilCandidato.vue';
import HomeEmpresa from '../views/HomeEmpresa.vue';
import PerfilEmpresa from '../views/PerfilEmpresa.vue';
import UpdateDN from '../views/UpdateDN.vue';
import UpdateEmail from '../views/UpdateEmail.vue';
import UpdateSenha from '../views/UpdateSenha.vue';
import AddRecrutador from '../views/AddRecrutador.vue';
import HomeRecrutador from '../views/HomeRecrutador.vue';
import AddVagas from '../views/AddVagas.vue';
import PerfilRecrutador from '../views/PerfilRecrutador.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home-candidato',
      name: 'home-candidato',
      component: HomeCandidato,
      meta: {
        title: 'Home Candidato',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/curriculo',
      name: 'curriculo',
      component: Curriculo,
      meta: {
        title: 'Currículo',
        requiresAuth: true,
        userType: 'candidato',
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
        title: 'Registrar Candidato',
      },
    },
    {
      path: '/register-empresa',
      name: 'register-empresa',
      component: RegisterEmpresa,
      meta: {
        title: 'Registrar Empresa',
      },
    },
    {
      path: '/meu-perfil',
      name: 'perfil-candidato',
      component: PerfilCandidato,
      meta: {
        title: 'Meu Perfil',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/home-empresa',
      name: 'home-empresa',
      component: HomeEmpresa,
      meta: {
        title: 'Home Empresa',
        requiresAuth: true,
        userType: 'empresa',
      },
    },
    {
      path: '/perfil-empresa',
      name: 'perfil-empresa',
      component: PerfilEmpresa,
      meta: {
        title: 'Perfil Empresa',
        requiresAuth: true,
        userType: 'empresa',
      },
    },
    {
      path: '/data-nascimento',
      name: 'data nascimento',
      component: UpdateDN,
      meta: {
        title: 'Data de Nascimento',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/email',
      name: 'email',
      component: UpdateEmail,
      meta: {
        title: 'Email',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/senha',
      name: 'senha',
      component: UpdateSenha,
      meta: {
        title: 'Senha',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/add-recrutador',
      name: 'adicionar-recrutador',
      component: AddRecrutador,
      meta: {
        title: 'Adicionar Recrutador',
        requiresAuth: true,
        userType: 'empresa',
      },
    },
    {
      path: '/home-recrutador',
      name: 'home-recrutador',
      component: HomeRecrutador,
      meta: {
        title: 'Home Recrutador',
        requiresAuth: true,
        userType: 'recrutador',
      },
    },
    {
      path: '/add-vaga',
      name: 'Adicionar Vaga',
      component: AddVagas,
      meta: {
        title: 'Adicionar Vaga',
        requiresAuth: true,
        userType: 'recrutador',
      },
    },
    {
      path: '/perfil-recrutador',
      name: 'Perfil Recrutador',
      component: PerfilRecrutador,
      meta: {
        title: 'Perfil Recrutador',
        requiresAuth: true,
        userType: 'recrutador',
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;

  const isAuthenticated = store.getters.isAuthenticated;
  const userRole = store.getters.userRole;

  if (to.path === '/login' && isAuthenticated) {
    if (userRole === 'candidato') {
      return next({ name: 'home-candidato' });
    } else if (userRole === 'empresa') {
      return next({ name: 'home-empresa' });
    } else if (userRole === 'recrutador') {
      return next({ name: 'home-recrutador' });
    }
  }

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      return next({ name: 'login' });
    }


    if (to.path.startsWith('/home-candidato') && userRole !== 'candidato') {
      return next({ name: 'home-empresa' });
    } else if (to.path.startsWith('/home-empresa') && userRole !== 'empresa') {
      return next({ name: 'home-candidato' });
    } else if (to.path.startsWith('/home-recrutador') && userRole !== 'recrutador') { 
      return next({ name: 'home-candidato' });
    }
  }

  next();
});

export default router;
