import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'
// import util from '../util'
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})

Vue.use(VueRouter)
// Vue.use(util)

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});


//路由开始前
router.beforeEach((to, from, next) => {
    // console.log('to', to);
    // console.log(from);
    // console.log(window.Admin);
    if (typeof window.Admin != 'undefined' && window.Admin.LoggedUser) {
        router.app.$store.commit('setUser', window.Admin.LoggedUser);
    }
    if (to.meta.title) {
        router.app.$store.commit('setMetaTitle', to.meta.title);
        document.title = router.app.$store.state.metaTitle + ' - ' + window.Admin.Title;
    }

    if (to.fullPath != '/#') {
        router.app.$Progress.start();

        if (to.meta.auth) {
            // if (typeof window.Admin != 'undefined' && window.Admin.PermList) {
                // store.commit('setPermissions', window.Admin.PermList);
            // }

            if (Object.keys(router.app.$store.state.user).length == 0) {
                return next({name: 'admin.login'});
            }

            if ($.inArray(to.name, ['admin.model.index', 'admin.model.create', 'admin.model.edit']) != -1) {
                if (Object.keys(router.app.$store.state.models).indexOf(to.params.model) == -1) {
                    router.app.axios.get('/admin/' + to.params.model + '/config')
                        .then(response => {
                            var data = {};
                            data[to.params.model] = response.data;
                            router.app.$store.commit('setModel', data);
                            router.app.$store.commit('setMetaTitle', response.data.title);
                            document.title = router.app.$store.state.metaTitle + ' - ' + window.Admin.Title;
                            next();
                        }).catch(error => {
                            next({name: 'admin.403'});
                        })
                } else {
                    to.meta.title = router.app.$store.state.models[to.params.model].title;
                    router.app.$store.commit('setMetaTitle', to.meta.title);
                    document.title = router.app.$store.state.metaTitle + ' - ' + window.Admin.Title;
                    next();
                }
            } else {
                if (typeof to.name == 'undefined' || to.name == '') {
                    return next({name: 'admin.403'});
                }
                router.app.axios.get('/admin/check/perm/' + to.name)
                    .then(response => {
                        router.app.$store.commit('setMetaTitle', to.meta.title);
                        document.title = router.app.$store.state.metaTitle + ' - ' + window.Admin.Title;
                        next();
                        // console.log('response', response.data);
                        /*store.commit('setPermissions', response.data);

                        if (Vue.can(to.name)) {
                            router.app.$store.commit('setMetaTitle', to.meta.title);
                            document.title = router.app.$store.state.metaTitle + ' - ' + window.Admin.Title;
                            next();
                        } else {
                            next({name: 'admin.403'});
                        }*/
                    }).catch(error => {
                        return next({name: 'admin.403'});
                    })
            }


            /*if (store.state.permissions.length == 0) {
                Vue.axios.get('/admin/permissions')
                    .then(response => {
                        // console.log('response', response.data);
                        store.commit('setPermissions', response.data);

                        if (Vue.can(to.name)) {
                            next();
                        } else {
                            // return next({name: 'admin.403'});
                        }
                    }).catch(error => {
                        // return next({name: 'admin.403'});
                    })
            } else {
                if (Vue.can(to.name)) {
                    next();
                } else {
                    // return next({name: 'admin.403'});
                }
            }*/
        } else {
            next();
        }
    }
});


//路由完成后
router.afterEach(route => {
    router.app.$Progress.finish();
});

export default router;