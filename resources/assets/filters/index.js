import scoHttp from './http.js'

const install = function (Vue) {
    Vue.prototype.scoHttp = scoHttp;
}
if (typeof window !== 'undefined' && window.Vue) {
    install(window.Vue);
};
export default {
    install
};