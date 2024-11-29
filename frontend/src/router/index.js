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
import MinhasVagas from '../views/MinhasVagas.vue';
import UpdateVaga from '../views/UpdateVaga.vue';
import Vagas from '../views/Vagas.vue';
import UpdateExProfissional from '../views/UpdateExProfissional.vue';
import UpdateIdioma from '../views/UpdateIdioma.vue';
import AnexarCurriculo from '../views/UpdateAnexarCurriculo.vue';
import UpdateConEcer from '../views/UpdateConEcer.vue';
import UpdateSkills from '../views/UpdateSkills.vue';
import UpdateFormacao from '../views/UpdateFormacao.vue';
import VerVaga from '../views/VerVaga.vue';
import Recrutadores from '../views/Recrutadores.vue';
import CurriculoInicio from '../views/CurriculoInicio.vue';
import ExProfissional from '../views/ExProfissional.vue';
import Formacao from '../views/Formacao.vue';
import Skills from '../views/Skills.vue';
import Idioma from '../views/Idioma.vue';
import VerCandidatos from  '../views/VerCandidatos.vue';

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
    {
      path: '/minhas-vagas',
      name: 'Minhas Vagas',
      component: MinhasVagas,
      meta: {
        title: 'Minhas Vagas',
        requiresAuth: true,
        userType: 'recrutador',
      },
    },

    {
      path: '/update-vaga/:id',
      name: 'UpdateVaga',
      component: UpdateVaga,
      meta: {
        title: 'Editar Vaga',
        requiresAuth: true,
        userType: 'recrutador',
      },
      props: true,
    },
    {
      path: '/vagas',
      name: 'Vagas',
      component: Vagas,
      meta: {
        title: 'Vagas',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/update-experiencia-profissional',
      name: 'update experiencia-profissional',
      component: UpdateExProfissional,
      meta: {
        title: 'Experiência Profissional',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/update-formacao',
      name: 'updateformacao',
      component: UpdateFormacao,
      meta: {
        title: 'Formação',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/update-conquistas-certificados',
      name: 'update conquistas-certificados',
      component: UpdateConEcer,
      meta: {
        title: 'Conquistas ou Certificados',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/update-skills',
      name: 'update skills',
      component: UpdateSkills,
      meta: {
        title: 'Skills',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/update-idiomas',
      name: 'update idiomas',
      component: UpdateIdioma,
      meta: {
        title: 'Idiomas',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/anexar-curriculo',
      name: 'anexar-curriculo',
      component: AnexarCurriculo,
      meta: {
        title: 'Anexar Currículo',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/ver-vaga/:id',
      name: 'ver-vaga',
      component: VerVaga,
      meta: {
        title: 'Ver Vaga',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/recrutadores',
      name: 'recrutadores',
      component: Recrutadores,
      meta: {
        title: 'Recrutadores',
        requiresAuth: true,
        userType: 'empresa',
      },
    },
    {
      path: '/curriculo-inicio',
      name: 'curriculo-inicio',
      component: CurriculoInicio,
      meta: {
        title: 'Currículo Inicial',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/experiencia-profissional',
      name: 'ex-profissional',
      component: ExProfissional,
      meta: {
        title: 'Experiência Profissional',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/formacao',
      name: 'formacao',
      component: Formacao,
      meta: {
        title: 'Formação',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/skills',
      name: 'skills',
      component: Skills,
      meta: {
        title: 'Skills',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/idioma',
      name: 'idioma',
      component: Idioma,
      meta: {
        title: 'Idioma',
        requiresAuth: true,
        userType: 'candidato',
      },
    },
    {
      path: '/ver-candidatos/:id',
      name: 'ver-candidatos',
      component: VerCandidatos,
      meta: {
        title: 'Ver Candidatos',
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

  if (to.path === '/') {
    if (!isAuthenticated) {
      return next({ name: 'login' });
    }
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
    if (to.meta.userType && to.meta.userType !== userRole) {
      return next({ name: 'login' });
    }
  }

  next();
});

export default router;
