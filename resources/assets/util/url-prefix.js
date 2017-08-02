
let getUrlPrefix = function () {
    let urlPrefix = 'admin';
    if (typeof window.Admin != 'undefined') {
        urlPrefix = window.Admin.UrlPrefix;
    }
    return urlPrefix;
}

/**
 * Install plugin
 * @param Vue
 */
const plugin = function (Vue) {

    if (plugin.installed) {
        return
    }
    plugin.installed = true

    Vue.getUrlPrefix = getUrlPrefix
    Object.defineProperties(Vue.prototype, {
        getUrlPrefix: {
            get() {
                return getUrlPrefix
            }
        }
    })
}

if (typeof exports == "object") {
    module.exports = plugin
} else if (typeof define == "function" && define.amd) {
    define([], function(){ return plugin })
} else if (window.Vue) {
    Vue.use(plugin)
}