import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: !!localStorage.getItem('authToken'),
    authToken: localStorage.getItem('authToken') || null,
    userRole: localStorage.getItem('userRole') || null,
    companyId: localStorage.getItem('companyId') || null,
    candidateId: localStorage.getItem('candidateId') || null,
    recruiterId: localStorage.getItem('recruiterId') || null,
    email: localStorage.getItem('email') || null,
    curriculumId: localStorage.getItem('curriculumId') || null, // Garantir que o curriculumId seja recuperado
  },
  mutations: {
    login(state, { token, role, companyId, candidateId, recruiterId, curriculumId, email }) {
      console.log('Curriculum ID na Mutation:', curriculumId); // Verificando se curriculumId chega corretamente

      state.isAuthenticated = true;
      state.authToken = token;
      state.userRole = role;
      state.companyId = companyId;
      state.candidateId = candidateId;
      state.recruiterId = recruiterId;
      state.curriculumId = curriculumId; // Armazenando curriculumId corretamente
      state.email = email;

      // Salvando os dados no localStorage
      localStorage.setItem('authToken', token);
      localStorage.setItem('userRole', role);
      localStorage.setItem('companyId', companyId);
      localStorage.setItem('candidateId', candidateId);
      localStorage.setItem('recruiterId', recruiterId);
      localStorage.setItem('curriculumId', curriculumId); // Salvando curriculumId
      localStorage.setItem('email', email);
    },
    logout(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      state.userRole = null;
      state.companyId = null;
      state.candidateId = null;
      state.recruiterId = null;
      state.curriculumId = null; // Resetando curriculumId
      state.email = null;
      
      // Removendo os dados do localStorage
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId');
      localStorage.removeItem('candidateId');
      localStorage.removeItem('recruiterId');
      localStorage.removeItem('curriculumId');
      localStorage.removeItem('email');
    },
  },
  actions: {
    login({ commit }, payload) {
      commit('login', payload);
    },
    logout({ commit }) {
      commit('logout');
    },
  },
  getters: {
    isAuthenticated: (state) => state.isAuthenticated,
    getAuthToken: (state) => state.authToken,
    userRole: (state) => state.userRole,
    getCompanyId: (state) => state.companyId,
    getCandidateId: (state) => state.candidateId,
    getRecruiterId: (state) => state.recruiterId,
    getUserEmail: (state) => state.email,
    getCurriculumId: (state) => state.curriculumId,
  },
});
