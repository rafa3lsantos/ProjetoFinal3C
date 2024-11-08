import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: !!localStorage.getItem('authToken'),
    authToken: localStorage.getItem('authToken') || null,
    userRole: localStorage.getItem('userRole') || null,
  },
  mutations: {
    login(state, { token, role }) {
      state.isAuthenticated = true;
      state.authToken = token;
      state.userRole = role;
      localStorage.setItem('authToken', token);
      localStorage.setItem('userRole', role);
    },
    logout(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      state.userRole = null;
      localStorage.removeItem('authToken');
      localStorage.removeItem('userRole');
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
  },
});
