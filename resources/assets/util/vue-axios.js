import axios from 'axios'
// import { Message } from 'element-ui'
import router from '../router'


// axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

axios.interceptors.response.use(null, error => {
    if (error.response) {
        if (error.response.status == 403) {
            router.push({name: 'admin.403'})
            return;
        }
        if (error.response.status == 401) {
            router.push({name: 'admin.login'})
            return;
        }
        // console.log(router.app.$Message);
        console.log('axios response', error.response);
        if (typeof error.response.data == 'object') {
            return Promise.reject(error);
        } else {
            router.app.$Message.error(error.response.data);
        }
    } else if (error.request) {
        // The request was made but no response was received
        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
        // http.ClientRequest in node.js
        console.log('axios request', error.request);
    } else {
        console.log('axios message', error.message);
        // Something happened in setting up the request that triggered an Error
        router.app.$Message.error(error.message);
    }
    return Promise.reject(error);
})

/**
 * Install plugin
 * @param Vue
 */
function plugin(Vue) {
    if (plugin.installed) {
        return
    }
    plugin.installed = true

    if (!axios) {
        console.error('You have to install axios')
        return
    }

    Vue.axios = axios

    Object.defineProperties(Vue.prototype, {
        axios: {
            get() {
                return axios
            }
        },
        $http: {
            get() {
                return axios
            }
        }
    })
}

if (typeof exports == "object") {
    module.exports = plugin
} else if (typeof define == "function" && define.amd) {
    define([], function(){ return plugin })
} else if (window.Vue && window.axios) {
    Vue.use(plugin)
}