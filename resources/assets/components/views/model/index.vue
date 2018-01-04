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
            <v-table v-if="config.display.type == 'table'"></v-table>
            <v-tree v-else-if="config.display.type == 'tree'"></v-tree>
            <v-image v-else-if="config.display.type == 'image'"></v-image>

        </div>
    </div>
</template>

<script>

    import vTable from './box/table.vue'
    import vTree from './box/tree.vue'
    import vImage from './box/image.vue'
    import getConfig from '../../../mixins/get-config'

    export default {
        mixins: [
            getConfig
        ],
        components: {
            vTable,
            vTree,
            vImage,
        },
        data() {
            return {
            }
        },
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

