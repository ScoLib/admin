import Vue from 'vue'

export default new Vue({
    data() {
        return {
        }
    },
    /*        beforeRouteEnter (to, from, next) {
     next();
     },*/
    created () {
        this.fetchData();
    },
    watch: {
        '$route': 'fetchData'
    },
    methods: {
        fetchData () {
//                this.$Message.info('这是一个消息', 200);
        }
    }
}).$mount('#app')