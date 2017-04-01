import Vue from 'vue';
import Loading from './components/Loading.vue';

let loadingInstance;


Loading.newInstance = properties => {
    const _props = properties || {};

    const el = document.createElement('loading');
    document.body.appendChild(el);

    const loading = new Vue({
        el: el,
        data: _props,
        components: {Loading}
    }).$children[0];

    return {
        start () {
            loading.start();
        },
        close () {
            loading.close();
        },
        component: loading,
    };

}

function getLoadingInstance() {
    loadingInstance = loadingInstance || Loading.newInstance();

    return loadingInstance;
}

const service = {
    start () {
        let instance = getLoadingInstance();
        instance.start();
    },
    close () {
        let instance = getLoadingInstance();
        instance.close();
    }
};

export default {
    install(Vue) {
        Vue.prototype.$loading = service
    },
    service
}