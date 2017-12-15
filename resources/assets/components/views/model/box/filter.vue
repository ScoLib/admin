<template>
    <div class="pull-right">
        <el-dialog title="筛选" :visible.sync="visible2">

            <div class="box-body form-horizontal">
                <div class="form-group" v-for="filter in filters">
                    <label :for="`label_${filter.name}`" class="col-sm-3 control-label">{{ filter.title }}</label>

                    <v-element
                            class="col-sm-9"
                            :element="filter"
                            v-model="currentValue[filter.name]">
                    </v-element>
                </div>
            </div>
            <!-- /.box-body -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="visible2 = false" class="btn btn-default">取 消</el-button>
                <el-button type="primary" @click="visible2 = false" class="btn btn-info pull-right">确 定</el-button>
            </div>

        </el-dialog>

        <el-button type="primary" class="btn-sm" @click="visible2 = true"><i class="fa fa-filter"></i> 筛选</el-button>
    </div>
</template>

<script>
    import getConfig from '../../../../mixins/get-config.js';
    import vModel from '../../../../mixins/model.js'
    import vElement from '../elements/element.vue'

    export default {
        name: "vFilter",
        data() {
            return {
                visible2:false
            }
        },
        mixins: [
            getConfig,
            vModel,
        ],
        components: {
            vElement,
        },
        computed: {

        },
        props: {
            filters: Object|Array
        }
    }
</script>

<style scoped>

</style>