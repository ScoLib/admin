import store from '../../store'

const setTitle = (title) => {
    store.commit('setMetaTitle', title);
    document.title = title + ' - ' + window.Admin.Title;
}

const getConfigs = (to, from, next) => {
    let vm = store._vm;
    let models = store.state.models;

    if (Object.keys(models).indexOf(to.params.model) == -1) {
        vm.$http.get(`/${vm.getUrlPrefix()}/${to.params.model}/config`)
            .then(response => {
                store.commit('setModel', {
                    key: to.params.model,
                    value: response.data
                });
                setTitle(to.meta.title + response.data.title);
                next();
            }).catch(error => {
            next({name: 'admin.403'});
        })
    } else {
        var　title = to.meta.title + models[to.params.model].title;
        setTitle(title)
        next();
    }
}

export default {
    beforeRouteEnter: getConfigs,
    beforeRouteUpdate: getConfigs,
    computed: {
        config() {
            let models = this.$store.state.models;
            let model = this.$route.params.model;
//                console.log(models[model]);
//                console.log(model);
//                console.log(Object.keys(models).indexOf(model));
            if (Object.keys(models).indexOf(model) == -1) {
                return {};
            } else {
//                    console.log(models[model]);
                return models[model];
            }
        },
    }
}