<template>
    <div class="hello">
        <h1>{{ title }}</h1>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                title: '控制台',
                breads: []
            }
        },
        beforeRouteEnter (to, from, next) {
            next();
        },
        created () {
            this.fetchData();
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.$Message.info('这是一个消息', 200);
            }
        }
    }
</script>

