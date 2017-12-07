<template>
    <div class="pull-right">
        <el-dialog title="筛选" :visible.sync="visible2">

            <div class="box-body form-horizontal">
                <div class="form-group" v-for="filter in filters">
                    <label :for="`label_${filter.name}`" class="col-sm-3 control-label">{{ filter.title }}</label>

                    <div class="col-sm-9">
                        <el-input
                                v-if="filter.type == 'text'"
                                :id="`label_${filter.name}`"
                                :placeholder="filter.title">
                        </el-input>
                        <el-select
                                v-else-if="filter.type == 'select'"
                                :name="filter.name"
                                placeholder="请选择">
                            <el-option
                                    v-for="option in filter.options"
                                    :key="option.value"
                                    :label="option.label"
                                    :value="option.value">
                            </el-option>
                        </el-select>

                        <el-radio-group
                                v-else-if="filter.type == 'radio'">
                            <el-radio
                                    v-for="option in filter.options"
                                    :key="option.value"
                                    :label="option.value">
                                {{ option.label }}
                            </el-radio>
                        </el-radio-group>

                        <el-checkbox-group
                                v-else-if="filter.type == 'checkbox'">
                            <el-checkbox
                                    v-for="option in filter.options"
                                    :key="option.value"
                                    :label="option.value">
                                {{ option.label }}
                            </el-checkbox>
                        </el-checkbox-group>

                        <el-date-picker
                                v-else-if="['date', 'datetime', 'daterange', 'datetimerange'].indexOf(filter.type) > -1"
                                :type="filter.type"
                                editable
                                :format="filter.pickerFormat"
                                :value-format="filter.pickerFormat"
                                placeholder="选择日期时间">
                        </el-date-picker>

                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="visible2 = false" class="btn btn-default">取 消</el-button>
                <el-button type="primary" @click="visible2 = false" class="btn btn-info pull-right">确 定</el-button>
            </div>

        </el-dialog>

        <!--<el-popover
                ref="view-filter"
                placement="left"
                v-model="visible2">
            <p>这是一段内容这是一段内容确定删除吗？</p>
            <div style="text-align: right; margin: 0">
                <el-button size="mini" type="text" @click="visible2 = false">取消</el-button>
                <el-button type="primary" size="mini" @click="visible2 = false">确定</el-button>
            </div>
        </el-popover>-->
        <el-button type="primary" class="btn-sm" @click="visible2 = true"><i class="fa fa-filter"></i> 筛选</el-button>
    </div>
</template>

<script>
    import getConfig from '../../../../mixins/get-config';

    export default {
        name: "vFilter",
        data() {
            return {
                visible2:false
            }
        },
        mixins: [
            getConfig
        ],
        computed: {
            filters() {
                return this.config.view.filters;
            }
        },
    }
</script>

<style scoped>

</style>