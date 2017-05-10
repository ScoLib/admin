import axios from './axios'

const install = function (Vue) {
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

if (typeof window !== 'undefined' && window.Vue) {
    install(window.Vue);
}

export default {
    install
}