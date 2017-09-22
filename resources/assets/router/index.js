import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from '../routes'
// import util from '../util'
// import iView from 'iview'

/*iView.LoadingBar.config({
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: 3
});*/

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    // failedColor: 'red',
    height: '3px'
})

Vue.use(VueRouter)

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior(to, from, savedPosition) {
        return savedPosition || {x: 0, y: 0}
    }
});

const setTitle = (title) => {
    router.app.$store.commit('setMetaTitle', title);
    document.title = title + ' - ' + window.Admin.Title;
}

//路由开始前
router.beforeEach((to, from, next) => {
    // console.log('to', to);
    // console.log(from);
    // console.log(window.Admin);

    if (to.meta.title) {
        setTitle(to.meta.title);
    }

    if (to.fullPath != '/#') {
        router.app.$Progress.start();


        if (to.name != 'admin.login' && Object.keys(router.app.$store.state.user).length == 0) {
            return next({name: 'admin.login'});
        }

        /*if (typeof to.name == 'undefined' || to.name == '') {
            return next({name: 'admin.403'});
        }*/

        if (['admin.404', 'admin.403', 'admin.500'].indexOf(to.name) > -1) {
            router.app.$Progress.fail();
        }

        next();
    }
});


//路由完成后
router.afterEach(route => {
    router.app.$Progress.finish();
});

export default router;