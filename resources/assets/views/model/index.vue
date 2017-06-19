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
                                <a href="#" @click.prevent="batchDestroy">
                                    <i class="fa fa-trash-o bigger-120"></i> 删除
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary" @click.prevent="fetchData">
                            <i class="fa fa-refresh"></i>
                            刷新
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
                <div class="box-body table-responsive no-padding">

                    <el-table :data="pageData.data"
                              v-loading="tableLoading"
                              @selection-change="getSelected">

                        <el-table-column
                                type="selection"
                                :selectable="selectable">
                        </el-table-column>

                        <el-table-column
                                :label="column.title"
                                :prop="column.key"
                                :width="column.width"
                                :fixed="column.fixed"
                                v-for="column in config.columns"
                                :key="column.key">
                        </el-table-column>

                        <el-table-column :label="$t('table.id')"
                                         prop="id"
                                         width="60">
                        </el-table-column>

                        <el-table-column :label="$t('table.name')" prop="name">
                        </el-table-column>

                        <el-table-column :label="$t('table.display_name')" prop="display_name">
                        </el-table-column>

                        <el-table-column label="创建时间" prop="created_at">
                        </el-table-column>

                        <el-table-column
                                label="操作"
                                width="120"
                                align="center"
                                column-key="index">
                            <template scope="scope">
                                <div class="hidden-xs btn-group">
                                    <router-link
                                            class="btn btn-xs btn-info"
                                            v-if="config.permissions.edit"
                                            :to="{name:'admin.model.edit', params:{model:$route.params.model,id:scope.row.id}}"
                                            title="编辑">
                                        <i class="fa fa-pencil bigger-120"></i>
                                    </router-link>
                                    <button class="btn btn-xs btn-danger"
                                            @click.prevent="destroy(scope.row.id)"
                                            :disabled="scope.row.name == 'admin'"
                                            v-if="config.permissions.delete"
                                            title="删除">
                                        <i class="fa fa-trash-o bigger-120"></i>
                                    </button>
                                </div>
                            </template>
                        </el-table-column>

                    </el-table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <el-pagination
                            layout="total, prev, pager, next"
                            :page-size="pageData.per_page"
                            @current-change="getResults"
                            :total="pageData.total">
                    </el-pagination>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        components: {
        },
        data() {
            return {

                // 列表
                tableLoading: false,
                pageData: {},

                selection: [],
                buttonLoading: false,
            }
        },
        computed: {
            config() {
                let models = this.$store.state.models;
                let model = this.$route.params.model;
                console.log(models[model]);
//                console.log(model);
//                console.log(Object.keys(models).indexOf(model));
                if (Object.keys(models).indexOf(model) == -1) {
                    return {};
                } else {
//                    console.log(models);
                    return models[model];
                }
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
                return row.name == 'admin' ? false : true;
            },
            getSelected(selection) {
                this.selection = [];
                selection.forEach(row => {
                    this.selection.push(row.id);
                });
            },
            getResults() {
                this.tableLoading = true;
                this.$http.get('/admin/' + this.$route.params.model + '/list').then(response => {
                    this.tableLoading = false;
                    this.pageData = response.data;
                }).catch(error => {})
            },
            destroy(id) {
                this.$confirm('确定要删除此角色吗？', '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
                            this.$http.delete('/admin/users/role/' + id)
                                .then(response => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                    this.$message.success('删除成功');
                                    this.getResults();
                                    this.flushPermission();
                                }).catch(error => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                            })
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});
            },
            batchDestroy() {
                if (this.selection.length == 0) {
                    this.$message.error('请选择操作对象');
                    return false;
                }

                this.$confirm('确定要执行删除角色操作吗？', '提示',{
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
//                            instance.confirmButtonText = '执行中...';
                            this.$http.post('/admin/users/role/batch/destroy', {'ids': this.selection})
                                .then(response => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                    this.$message.success('删除成功');
                                    this.getResults();
                                    this.flushPermission();
                                }).catch(error => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                            })
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});
            },
            flushPermission() {
                this.$store.commit('setPermissions', []);
            }
        }
    }
</script>

