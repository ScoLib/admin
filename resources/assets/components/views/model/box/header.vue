<template>
    <div class="box-header clearfix">
        <div class="btn-group btn-group-sm">
            <router-link
                    :to="{ name: 'admin.model.create', params: {model: $route.params.model}}"
                    v-if="config.accesses.create"
                    class="btn btn-default">
                <i class="fa fa-plus"></i>
                创建 {{ config.title }}
            </router-link>
        </div>
        <div class="btn-group btn-group-sm margin-r-5">
            <button type="button" class="btn btn-primary" @click.prevent="refresh">
                <i class="fa fa-refresh"></i>
                {{ $t('table.refresh') }}
            </button>
        </div>
        <slot></slot>
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
    </div>
</template>

<script>
    import mixins from '../../../../mixins/get-config'

    export default {
        name: 'vHeader',
        data() {
            return {
                visible2:false
            }
        },
        mixins: [
            mixins
        ],
        computed: {

        },
        methods: {
            refresh() {
                this.$emit('refresh');
            }
        }
    }
</script>