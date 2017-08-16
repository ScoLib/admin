import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        models: {},
        metaTitle: '',
        modelCreateInfo: {},
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setModel(state, data) {
            state.models[data.key] = data.value;
        },
        setMetaTitle(state, title) {
            state.metaTitle = title ? title : '';
        },
        setModelCreateInfo(state, data) {
            state.modelCreateInfo[data.key] = data.value;
        }
    }
});