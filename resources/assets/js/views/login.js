import Vue from 'vue'

export default new Vue({
    data() {
        return {
            info: {
                email: '',
                password: '',
                remember: true,
            },
            buttonLoading: false,
            errors: {},
        }
    },
    methods: {
        login () {
            this.buttonLoading = true;
            this.$http.post('/admin/login', this.info).then(response => {
//                    this.buttonLoading = false;
                location.href = '/admin'
            }).catch(error => {
                this.buttonLoading = false;
                this.errors = error.response.data;
            })
        }
    }
}).$mount('#app')