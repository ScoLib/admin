<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clearfix">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default">批量操作</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li v-if="config.permissions.delete">
                                <a href="#" @click.prevent="batchDelete">
                                    <i class="fa fa-trash-o bigger-120"></i> 删除
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary" @click.prevent="fetchData">
                            <i class="fa fa-refresh"></i>
                            {{ $t('table.refresh') }}
                        </button>
                    </div>


                    <div class="btn-group btn-group-sm pull-right margin-r-5">
                        <router-link
                                :to="{ name: 'admin.model.create', params: {model: $route.params.model}}"
                                v-if="config.permissions.create"
                                class="btn btn-default">
                            <i class="fa fa-plus bigger-120"></i>
                            创建 {{ config.title }}
                        </router-link>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">

                    <Table
                            :data="tableData"
                            v-loading="tableLoading"
                            @on-selection-change="getSelected"
                            :columns="columns">
                    </Table>

                    <!--<el-table :data="pageData.data"
                              v-loading="tableLoading"
                              @selection-change="getSelected">

                        <el-table-column
                                type="selection"
                                :selectable="selectable">
                        </el-table-column>

                        <el-column
                                :column="column"
                                v-for="column in config.columns"
                                :key="column.key">
                        </el-column>

                        &lt;!&ndash;<el-table-column
                                :label="column.title"
                                :prop="column.key"
                                :min-width="column.minWidth"
                                :sortable="column.sortable"
                                :fixed="column.fixed"
                                v-for="column in config.columns"
                                :key="column.key">
                        </el-table-column>&ndash;&gt;

                        <el-table-column
                                label="操作"
                                align="center"
                                width="120"
                                column-key="index">
                            <template scope="scope">
                                <div class="hidden-xs btn-group">
                                    <router-link
                                            class="btn btn-xs btn-info"
                                            v-if="config.permissions.edit"
                                            :to="{name:'admin.model.edit', params:{model:$route.params.model,id:scope.row[config.primaryKey]}}"
                                            title="编辑">
                                        <i class="fa fa-pencil bigger-120"></i>
                                    </router-link>
                                    <button class="btn btn-xs btn-danger"
                                            @click.prevent="destroy(scope.row[config.primaryKey])"
                                            v-if="config.permissions.delete"
                                            title="删除">
                                        <i class="fa fa-trash-o bigger-120"></i>
                                    </button>
                                </div>
                            </template>
                        </el-table-column>

                    </el-table>-->
                </div>
                <!-- /.box-body -->
                <div v-if="pageData.per_page" class="box-footer clearfix">
                    <!--<el-pagination
                            layout="total, prev, pager, next"
                            :page-size="pageData.per_page"
                            @current-change="getResults"
                            :total="pageData.total">
                    </el-pagination>-->
                    <Page
                            :page-size="pageData.per_page"
                            :current="pageData.current_page"
                            show-total
                            size="small"
                            @on-change="getResults"
                            :total="pageData.total"></Page>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    import actionColumn from '../../components/actionColumn'

    export default {
        mixins: [actionColumn],
        components: {
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
            config() {
                let models = this.$store.state.models;
                let model = this.$route.params.model;
//                console.log(models[model]);
//                console.log(model);
//                console.log(Object.keys(models).indexOf(model));
                if (Object.keys(models).indexOf(model) == -1) {
                    return {};
                } else {
//                    console.log(models[model]);
                    return models[model];
                }
            },
            columns() {
                let columns = [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    }
                ];
                this.config.columns.forEach(function (column) {
//                    console.log(column.render);
                    var self = this;
                    if (typeof column.template !== 'undefined') {
                        Vue.component(column.key + 'column-render', {
                            template: column.template,
                            data() {
                                return {}
                            },
                            props: {
                                item: {
                                    type: Array | Object,
                                    default() {
                                        return {}
                                    }
                                }
                            }
                        });
                        delete column.template;

                        column.render = (h, params) => {
                            let renderStr;
                            if (params.row[column.key] instanceof Array && params.row[column.key].length) {
                                return params.row[column.key].map((item, index) => {
                                    try {
                                        return h(column.key + 'column-render', {
                                            props: {
                                                item
                                            }
                                        });
                                    } catch (e) {
                                        console.log(e);
                                        self.$Message.error('column(' + column.key +') template is wrong');
                                    }
                                });
                            } else {
                                try {
                                    return h(column.key + 'column-render', {
                                        props: {
                                            item: params.row[column.key]
                                        }
                                    });
                                } catch (e) {
                                    console.log(e);
                                    self.$Message.error('column(' + column.key +') template is wrong');
                                }
                            }
//                            console.log(renderStr);
                            return (renderStr);
                        }
                    }
                    columns.push(column);
                });
//                console.log(this.getActionButtons());
                if (this.isActionColumn) {
                    columns.push({
                        title: '操作',
                        key: 'action',
                        width: 150,
                        align: 'center',
                        render: (h, params) => {
                            const buttons = this.getActionButtons(h, params.row);
                            return (
                                <div class="hidden-xs btn-group">
                                {buttons}
                                </div>
                            );
                        }
                    });
                }
//                console.log(columns);
                return columns;
            },
            urlPrefix() {
                return this.$store.state.urlPrefix;
            }
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
                this.$http.get(`/${this.urlPrefix}/${this.$route.params.model}/list`, {params: {'page': page}})
                    .then(response => {
                        this.tableLoading = false;
                        this.pageData = response.data;
                    }).catch(error => {})
            },

            batchDelete() {
                if (this.selection.length == 0) {
                    this.$Message.error('请选择操作对象');
                    return false;
                }

                this.$Modal.confirm({
                    title: '提示',
                    content: `确定要执行批量删除${this.config.title}操作吗？`,
                    loading: true,
                    onOk: () => {
                        this.$http.post(`/${this.urlPrefix}/${this.$route.params.model}/batch/delete`, {'ids': this.selection})
                            .then(response => {
                                this.$Modal.remove();
                                this.$Message.success('删除成功');
                                this.getResults();
                            }).catch(error => {
                                this.$Modal.remove();
                            })
                    }
                });
            },

        }
    }
</script>

