import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: !!localStorage.getItem('authToken'),
    authToken: localStorage.getItem('authToken') || null,
    userRole: localStorage.getItem('userRole') || null,
    companyId: localStorage.getItem('companyId') || null, // Adicionando companyId
  },
  mutations: {
    login(state, { token, role, companyId }) {
      state.isAuthenticated = true;
      state.authToken = token;
      state.userRole = role;
      state.companyId = companyId; // Salvando companyId
      localStorage.setItem('authToken', token);
      localStorage.setItem('userRole', role);
      localStorage.setItem('companyId', companyId); // Salvando companyId no localStorage
    },
    logout(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      state.userRole = null;
      state.companyId = null; // Limpa o companyId ao fazer logout
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId'); // Removendo companyId do localStorage
    },
  },
  actions: {
    login({ commit }, payload) {
      commit('login', payload);
      // Garantir que todos os dados de autenticação e companyId sejam sincronizados no localStorage
      localStorage.setItem('authToken', payload.token);
      localStorage.setItem('userRole', payload.role);
      localStorage.setItem('companyId', payload.companyId);
    },
    logout({ commit }) {
      commit('logout');
      // Limpeza do localStorage ao fazer logout
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
      localStorage.removeItem('companyId');
    },
  },
  getters: {
    isAuthenticated: (state) => state.isAuthenticated,
    getAuthToken: (state) => state.authToken,
    userRole: (state) => state.userRole,
    getCompanyId: (state) => state.companyId, // Getter para acessar o companyId
  },
});
