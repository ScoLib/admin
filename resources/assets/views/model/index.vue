<style>
    .el-table table,
    .el-table__empty-block {
        width: 100% !important;
    }
</style>

<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clearfix">
                    <div class="btn-group btn-group-sm">
                        <router-link
                                :to="{ name: 'admin.model.create', params: {model: $route.params.model}}"
                                v-if="config.permissions.create"
                                class="btn btn-default">
                            <i class="fa fa-plus bigger-120"></i>
                            创建 {{ config.title }}
                        </router-link>
                    </div>
                    <div class="btn-group btn-group-sm margin-r-5">
                        <button type="button" class="btn btn-primary" @click.prevent="fetchData">
                            <i class="fa fa-refresh"></i>
                            {{ $t('table.refresh') }}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <el-table :data="tableData"
                              v-loading="tableLoading"
                              @selection-change="getSelected">

                        <!--<el-table-column
                                type="selection"
                                :selectable="selectable">
                        </el-table-column>-->

                        <el-table-column
                                :label="column.label"
                                :prop="column.name"
                                :min-width="column.minWidth"
                                :width="column.width"
                                :sortable="column.sortable"
                                :fixed="column.fixed"
                                v-for="column in config.view.columns"
                                :key="column.name">
                            <template scope="scope">
                                <v-column
                                        :renderContent="column.render"
                                        :template="column.template"
                                        :scope="scope"
                                        :prop="column.name">
                                </v-column>
                            </template>
                        </el-table-column>

                        <el-table-column
                                label="操作"
                                align="center"
                                width="120"
                                column-key="action"
                                v-if="isActionColumn">
                            <template scope="scope">
                                <action-column
                                        :scope="scope"
                                        @change="getResults">
                                </action-column>
                            </template>
                        </el-table-column>


                    </el-table>
                </div>
                <!-- /.box-body -->
                <div v-if="pageData.total" class="box-footer clearfix">
                    <el-pagination
                            layout="total, prev, pager, next"
                            :page-size="pageData.per_page"
                            :current-page="pageData.current_page"
                            @current-change="getResults"
                            :total="pageData.total">
                    </el-pagination>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import vColumn from '../../components/column'
    import ActionColumn from './action-column.vue'
    import mixins from './mixins'

    export default {
        mixins: [
            mixins
        ],
        components: {
            vColumn,
            ActionColumn
        },
        data() {
            return {

                // 列表
                tableLoading: false,
                pageData: {
                    type: Object|Array,
                    default() {
                        return [];
                    }
                },

                selection: [],
                buttonLoading: false,
            }
        },
        computed: {
            tableData() {
                if (Object.keys(this.pageData).length == 0) {
                    return [];
                }
                if (Object.keys(this.pageData).indexOf('data') > -1) {
                    return this.pageData.data;
                }
                return this.pageData;
            },

            isActionColumn() {
                var permissions = this.config.permissions;
                return permissions.edit || permissions.delete || permissions.restore;
            },
        },
        created () {
            this.fetchData();
        },
        watch: {
            '$route'() {
                this.fetchData();
            }
        },
        methods: {
            fetchData () {
                this.getResults();
            },
            selectable(row, index) {
                return true;
//                return row.name == 'admin' ? false : true;
            },
            getSelected(selection) {
                this.selection = [];
                selection.forEach(row => {
                    this.selection.push(row[this.config.primaryKey]);
                });
//                console.log(this.selection);
            },
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.pageData = {};
                this.tableLoading = true;
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/list`, {params: {'page': page}})
                    .then(response => {
                        this.tableLoading = false;
                        this.pageData = response.data;
                    }).catch(error => {})
            },

            batchDelete() {
                if (this.selection.length == 0) {
                    this.$message.error('请选择操作对象');
                    return false;
                }

                this.$confirm(`确定要执行批量删除${this.config.title}操作吗？`, '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
                            //                            instance.confirmButtonText = '执行中...';
                            this.$http.post(`/${this.getUrlPrefix()}/${this.$route.params.model}/batch/delete`, {
                                'ids': this.selection
                            }).then(response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('删除成功');
                                this.getResults();
                            }).catch(error => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                            })
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});

                /*this.$confirm({
                    title: '提示',
                    content: `确定要执行批量删除${this.config.title}操作吗？`,
                    loading: true,
                    onOk: () => {
                        this.$http.post(`/${this.urlPrefix}/${this.$route.params.model}/batch/delete`, {'ids': this.selection})
                            .then(response => {
                                this.$Modal.remove();
                                this.$message.success('删除成功');
                                this.getResults();
                            }).catch(error => {
                                this.$Modal.remove();
                            })
                    }
                });*/
            },

        }
    }
</script>

