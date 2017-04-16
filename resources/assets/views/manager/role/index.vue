<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#">
                            列表
                        </a>
                    </li>


                </ul>

                <div class="tab-content">
                    <div class="box">
                        <div class="box-header clearfix">
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary btn-xs btn-white dropdown-toggle">
                                    批量
                                    <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" @click.prevent="batchRemove">
                                            <i class="fa fa-trash-o bigger-120"></i> 删除
                                        </a>
                                    </li>
                                </ul>
                            </div>


                            <div class="btn-group pull-right">
                                <router-link class="btn btn-success btn-xs" to="/admin/manager/role/create">
                                    <i class="fa fa-plus bigger-120"></i>
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

                                <el-table-column :label="$t('table.id')"
                                                 prop="id"
                                                 width="60">
                                </el-table-column>

                                <el-table-column :label="$t('table.name')" prop="name">
                                </el-table-column>

                                <el-table-column label="显示名称" prop="display_name">
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
                                            <button class="btn btn-xs btn-info"
                                                    @click.prevent="edit(scope.$index)"
                                                    title="编辑">
                                                <i class="fa fa-pencil bigger-120"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger"
                                                    @click.prevent="remove(scope.row.id)"
                                                    :disabled="scope.row.id == 1"
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
            <el-dialog :title="modalTitle" v-model="editModal">
                <form-dialog :info="info" :errors="errors"></form-dialog>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="save" :loading="buttonLoading">确 定</el-button>
                </div>
            </el-dialog>



        </div>
    </div>
</template>

<script>

    import FormDialog from './dialog.vue';

    export default {
        components: {
            FormDialog
        },
        data() {
            return {
                // 编辑
                editModal: false,
                info: {},
                modalLoading: true,
                errors: {},

                // 列表
                tableLoading: false,
                pageData: {},

                selection: [],
                buttonLoading: false,

                // 角色
                setRoleModal: false,
                roleData: {},
                roleList: {},
            }
        },
        computed: {
            modalTitle () {
                return this.info.id ? this.$t('form.edit_role') : this.$t('form.create_role');
            }
        },
        created () {
            this.getResults();
        },
        watch: {
        },
        methods: {
            selectable (row, index) {
                return row.id == 1 ? false : true;
            },
            getSelected (selection) {
                this.selection = [];
                selection.forEach(row => {
                    this.selection.push(row.id);
                });
            },
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.tableLoading = true;
                this.scoHttp('/admin/manager/role/list', {'page': page}, response => {
                    this.tableLoading = false;
                    this.pageData = response.data;
                });
            },
            add () {
                this.editModal = true;
                this.info = {};
                this.errors = {};
            },
            edit (index) {
                this.editModal = true;
                this.info = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    email: this.pageData.data[index].email,
                };
                this.errors = {};
            },
            remove (id) {
                this.$confirm('确定要删除此管理员吗？', '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            this.MessageBoxInstance = instance;

                            instance.confirmButtonLoading = true;
                            this.scoHttp('delete', '/admin/manager/user/' + id, response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('删除成功');
                                this.getResults();
                            });
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});
            },
            save () {
                this.buttonLoading = true;
                this.scoHttp('post', '/admin/manager/user/save', this.info, response => {
                    this.editModal = false;
                    this.buttonLoading = false;
                    this.getResults();
                });
            },
            authorize (index) {
                this.setRoleModal = true;
                this.buttonLoading = false;
                this.roleData = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    roles: [],
                };

                this.pageData.data[index].roles.forEach(role => {
                    this.roleData.roles.push(role.id);
                });
            },
            saveRole () {
                this.buttonLoading = true;
                this.scoHttp('post', '/admin/manager/user/save/role', this.roleData, response => {
                    this.setRoleModal = false;
                    this.buttonLoading = false;
                    this.getResults();
                });
            },
            batchRemove () {
                if (this.selection.length == 0) {
                    this.$message.error('请选择操作对象');
                    return false;
                }

                this.$confirm('确定要执行删除角色操作吗？', '提示',{
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            this.MessageBoxInstance = instance;

                            instance.confirmButtonLoading = true;
                            instance.confirmButtonText = '执行中...';

                            this.scoHttp('post', '/admin/system/menu/batch/delete', {'ids': this.selection}, response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('删除成功');
                                this.getResults();
                            });
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});
            },
        }
    }
</script>

