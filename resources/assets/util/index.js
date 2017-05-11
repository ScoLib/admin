import axios from './axios'
import can from './can'

const install = function (Vue) {
    Vue.axios = axios
    Vue.can = can
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
        },
        can: {
            get() {
                return can
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