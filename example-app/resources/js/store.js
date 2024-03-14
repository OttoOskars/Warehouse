import { createStore } from 'vuex';

export default createStore({
  state: {
    isAuthenticated: false,
  },
  mutations: {
    setAuthenticated(state, value) {
      state.isAuthenticated = value;
    },
    clearAuthentication(state) {
      state.isAuthenticated = false;
      localStorage.removeItem('user_token');
    },
  },
  actions: {
    logout({ commit }) {
      commit('clearAuthentication');
    },
  },
});
