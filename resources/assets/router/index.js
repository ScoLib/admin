import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'
import store from '../store'
import util from '../util'

Vue.use(VueRouter)
Vue.use(util)

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
        store.commit('setUser', window.Admin.LoggedUser);
    }

    if (to.fullPath != '/#') {

        if (to.meta.auth) {
            // if (typeof window.Admin != 'undefined' && window.Admin.PermList) {
                // store.commit('setPermissions', window.Admin.PermList);
            // }

            if (Object.keys(store.state.user).length == 0) {
                return next({name: 'admin.login'});
            }

            if ($.inArray(to.name, ['admin.model.index', 'admin.model.create', 'admin.model.edit']) != -1) {
                if (Object.keys(store.state.models).indexOf(to.params.model) == -1) {
                    Vue.axios.get('/admin/' + to.params.model + '/config')
                        .then(response => {
                            var data = {};
                            data[to.params.model] = response.data;
                            store.commit('setModel', data);
                            store.commit('setMetaTitle', response.data.title);
                            document.title = store.state.metaTitle + ' - ' + window.Admin.Title;
                        }).catch(error => {})
                } else {
                    to.meta.title = store.state.models[to.params.model].title;
                    store.commit('setMetaTitle', to.meta.title);
                    document.title = store.state.metaTitle + ' - ' + window.Admin.Title;
                }
            } else {
                store.commit('setMetaTitle', to.meta.title);
                document.title = store.state.metaTitle + ' - ' + window.Admin.Title;
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
            next();
        } else {
            next();
        }
    }
});


//路由完成后
router.afterEach(route => {
});

export default router;