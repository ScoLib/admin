<template>
    <div class="pull-right">
        <el-popover
                ref="view-filter"
                placement="left"
                v-model="visible2">
            <p>这是一段内容这是一段内容确定删除吗？</p>
            <div style="text-align: right; margin: 0">
                <el-button size="mini" type="text" @click="visible2 = false">取消</el-button>
                <el-button type="primary" size="mini" @click="visible2 = false">确定</el-button>
            </div>
        </el-popover>
        <el-button type="primary" class="btn-sm" v-popover:view-filter><i class="fa fa-filter"></i> 筛选</el-button>
    </div>
</template>

<script>
    export default {
        name: "vFilter",
        data() {
            return {
                visible2:false
            }
        }
    }
</script>

<style scoped>

</style>