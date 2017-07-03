require('jquery');
require('bootstrap');
require('./js');

import Vue from 'vue';
// import iView from 'iview';
import ElementUI from 'element-ui';
import i18n from './lang';
import store from './store';
import router from './router';
import App from './components/App.vue';
import util from './util';
// import ElLoading from 'element-loading'

// Vue.use(iView);
// Vue.use(ElLoading);

Vue.use(ElementUI, {
    i18n: function(path, options) {
        let value = i18n.t(path, options);
        if (value !== null && value !== undefined) return value;

        return '';
    }
})

Vue.use(util);

/*Vue.component(
    'bForm',
    require('./components/Form.vue')
);*/

/*Vue.component(
    'bInput',
    require('./components/Input.vue')
);*/

const app = new Vue({
    router,
    store,
    i18n,
    render: h => h(App),
}).$mount('#app');
