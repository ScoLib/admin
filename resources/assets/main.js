require('jquery');
require('bootstrap');
require('./js');

import Vue from 'vue';
import VueResource from 'vue-resource';
import ElementUI from 'element-ui';

import store from './store';
import router from './router';
import locales from './lang';
import App from './components/App.vue';
import filters from './filters';

Vue.use(VueResource);
Vue.use(ElementUI);
Vue.use(filters);

Vue.component(
    'FormGroup',
    require('./components/FormGroup.vue')
);

Vue.component(
    'bForm',
    require('./components/Form.vue')
);

Vue.component(
    'bInput',
    require('./components/Input.vue')
);

const app = new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');
