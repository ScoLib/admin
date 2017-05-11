<style>
    .help-block {
        margin-top: 5px;
        margin-bottom: 10px;
    }
</style>
<template>
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="locked text-center" style="font-size: 42px;">
            <i class="fa fa-lock"></i>
        </div>

        <div class="lockscreen-logo">
            <b>403</b>
        </div>

        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            对不起，你没有权限操作这个页面
        </div>
        <div class="text-center">
            <button @click.prevent="$router.go(-1)" class="btn btn-success btn-block">返  回</button>
        </div>
    </div>
    <!-- /.center -->
</template>

<script>
    export default {
        data() {
            return {}
        }
    }
</script>