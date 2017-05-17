require('jquery');
require('bootstrap');
require('./js');

import Vue from 'vue';
import ElementUI from 'element-ui';
import i18n from './lang';
import util from './util';

Vue.use(ElementUI, {
    i18n: function(path, options) {
        let value = i18n.t(path, options);
        if (value !== null && value !== undefined) return value;

        return '';
    }
})

Vue.use(util);

Vue.component(
    'bForm',
    require('./components/Form.vue')
);

Vue.component(
    'bInput',
    require('./components/Input.vue')
);

const app = new Vue({
    i18n,
}).$mount('#app');
