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
/*router.beforeEach((to, from, next) => {
    // console.log('to', to);
    // console.log(from);
    if (typeof window.LoggedUser != 'undefined') {
        store.commit('setUser', window.LoggedUser);
    }

    if (to.fullPath != '/#') {
        let title = 'Sco Admin';
        if (to.meta.title) {
            title = to.meta.title + ' - ' + title;
        }
        document.title = title;

        if (to.meta.auth) {
            if (typeof window.PermList != 'undefined') {
                store.commit('setPermissions', window.PermList);
            }

            if (Object.keys(store.state.user).length == 0) {
                return next({name: 'admin.login'});
            }

            if (store.state.permissions.length == 0) {
                Vue.axios.get('/admin/permissions')
                    .then(response => {
                        // console.log('response', response.data);
                        store.commit('setPermissions', response.data);

                        if (Vue.can(to.name)) {
                            next();
                        } else {
                            return next({name: 'admin.403'});
                        }
                    }).catch(error => {
                        return next({name: 'admin.403'});
                    })
            } else {
                if (Vue.can(to.name)) {
                    next();
                } else {
                    return next({name: 'admin.403'});
                }
            }
        } else {
            next();
        }
    }
});*/


//路由完成后
router.afterEach(route => {
});

export default router;