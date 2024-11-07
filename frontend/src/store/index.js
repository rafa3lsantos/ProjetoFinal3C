import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: !!localStorage.getItem('authToken'),
    authToken: localStorage.getItem('authToken') || null,
  },
  mutations: {
    login(state, token) {
      state.isAuthenticated = true;
      state.authToken = token;
      localStorage.setItem('authToken', token);
    },
    logout(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      localStorage.removeItem('authToken');
    },
    clearAuthToken(state) {
      state.isAuthenticated = false;
      state.authToken = null;
      localStorage.removeItem('authToken');
    },
  },
  actions: {
    login({ commit }, token) {
      commit('login', token);
    },
    logout({ commit }) {
      commit('logout');
    },
    clearAuthToken({ commit }) {
      commit('clearAuthToken');
    }
  },
  getters: {
    isAuthenticated: (state) => state.isAuthenticated,
    getAuthToken: (state) => state.authToken,
  },
});
