import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: !!localStorage.getItem('authToken'),
    authToken: localStorage.getItem('authToken') || null,
    userRole: localStorage.getItem('userRole') || null,
    companyId: localStorage.getItem('companyId') || null,
  },
  mutations: {
    login(state, { token, role, companyId }) {
      state.isAuthenticated = true;
      state.authToken = token;
      state.userRole = role;
      state.companyId = companyId;
      localStorage.setItem('authToken', token);
      localStorage.setItem('userRole', role);
      localStorage.setItem('companyId', companyId);
    },
    logout(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      state.userRole = null;
      state.companyId = null;
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId');
    },
  },
  actions: {
    login({ commit }, payload) {
      commit('login', payload);
      localStorage.setItem('authToken', payload.token);
      localStorage.setItem('userRole', payload.role);
      localStorage.setItem('companyId', payload.companyId);
    },
    logout({ commit }) {
      commit('logout');
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId');
    },
  },
  getters: {
    isAuthenticated: (state) => state.isAuthenticated,
    getAuthToken: (state) => state.authToken,
    userRole: (state) => state.userRole,
    getCompanyId: (state) => state.companyId,
  },
});
