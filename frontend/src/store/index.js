import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: !!localStorage.getItem('authToken'),
    authToken: localStorage.getItem('authToken') || null,
    userRole: localStorage.getItem('userRole') || null,
    companyId: localStorage.getItem('companyId') || null,
    candidateId: localStorage.getItem('candidateId') || null,
  },
  mutations: {
    login(state, { token, role, companyId,candidateId }) {
      state.isAuthenticated = true;
      state.authToken = token;
      state.userRole = role;
      state.companyId = companyId;
      state.candidateId = candidateId;
      localStorage.setItem('authToken', token);
      localStorage.setItem('userRole', role);
      localStorage.setItem('companyId', companyId);
      localStorage.setItem('candidateId', candidateId);
    },
    logout(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      state.userRole = null;
      state.companyId = null;
      state.candidateId = null;
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId');
      localStorage.removeItem('candidateId');
    },
  },
  actions: {
    login({ commit }, payload) {
      commit('login', payload);
      localStorage.setItem('authToken', payload.token);
      localStorage.setItem('userRole', payload.role);
      localStorage.setItem('companyId', payload.companyId);
      localStorage.setItem('candidateId', payload.candidateId);
    },
    logout({ commit }) {
      commit('logout');
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId');
      localStorage.removeItem('candidateId');
    },
  },
  getters: {
    isAuthenticated: (state) => state.isAuthenticated,
    getAuthToken: (state) => state.authToken,
    userRole: (state) => state.userRole,
    getCompanyId: (state) => state.companyId,
    getCandidateId: (state) => state.candidateId,
  },
});
