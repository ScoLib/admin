import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        permissions: [],
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setPermissions(state, permissions) {
            state.permissions = permissions;
        }
    }
});