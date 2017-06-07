import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        permissions: [],
        models: {},
        metaTitle: '',
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setPermissions(state, permissions) {
            state.permissions = permissions;
        },
        setModel(state, data) {
            state.models = Object.assign(state.models, data);
        },
        setMetaTitle(state, title) {
            state.metaTitle = title ? title : '';
        }
    }
});