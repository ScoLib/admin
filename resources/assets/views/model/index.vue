<style>
    .el-table table,
    .el-table__empty-block {
        width: 100% !important;
    }
    .fullscreen-v-img {
        z-index: 1031;
    }
</style>

<template>
    <div class="row">
        <div class="col-xs-12">
            <v-table v-if="config.view.type == 'table'"></v-table>
            <v-tree v-else-if="config.view.type == 'tree'"></v-tree>

        </div>
    </div>
</template>

<script>

    import vTable from './box/table.vue'
    import vTree from './box/tree.vue'
    import mixins from './mixins'

    export default {
        components: {
            vTable,
            vTree,
        },
        data() {
            return {


            }
        },
        mixins: [
            mixins
        ],
        computed: {

        },
        created () {

        },
        watch: {

        },
        methods: {

        }
    }
</script>

