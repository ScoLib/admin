let _ = require('lodash');
// require('jquery');
require('bootstrap');
require('./js');

import Vue from 'vue';
import ElementUI from 'element-ui';
import i18n from './locale';
import store from './store';
import router from './router';
import App from './components/app.vue'
import VueAxios from './util/vue-axios'
import UrlPrefix from './util/url-prefix'

Vue.use(ElementUI, {
    i18n: function(path, options) {
        let value = i18n.t(path, options);
        if (value !== null && value !== undefined) return value;

        return '';
    }
})

Vue.use(VueAxios);
Vue.use(UrlPrefix);

// set logged user
if (typeof window.Admin != 'undefined') {
    if (window.Admin.LoggedUser) {
        store.commit('setUser', window.Admin.LoggedUser);
    }
}

const app = new Vue({
    router,
    store,
    i18n,
    render: h => h(App),
}).$mount('#app');
