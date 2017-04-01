<style>
    .spin-container {
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 110000;
        width: 100%;
        height: 100%;
        /*opacity: 0.2;*/
    }
    .ivu-spin-fix {
        background-color: initial;
    }
</style>

<template>
    <!-- 加载条 -->
    <div class="spin-container" v-if="loading">
        <Spin fix size="large"></Spin>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loading: false,
            }
        },
        methods: {
            start() {
                this.loading = true;
            },
            close() {
                this.loading = false;
            }
        }
    }
</script>