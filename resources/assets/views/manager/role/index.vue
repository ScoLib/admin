<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clearfix">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm">批量操作</button>
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" @click.prevent="batchRemove">
                                    <i class="fa fa-trash-o bigger-120"></i> 删除
                                </a>
                            </li>
                        </ul>
                    </div>


                    <div class="btn-group btn-group-sm pull-right margin-r-5">
                        <router-link class="btn btn-default" to="/admin/manager/role/create">
                            <i class="fa fa-plus bigger-120"></i>
                        </router-link>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                    <el-table :data="roleList"
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
                roleList: [],

                selection: [],
                buttonLoading: false,

                // 角色
                setRoleModal: false,
                roleData: {},
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
            getResults() {
                this.tableLoading = true;
                this.scoHttp('/admin/manager/role/list', response => {
                    this.tableLoading = false;
                    this.roleList = response.data;
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
                    id: this.roleList[index].id,
                    name: this.roleList[index].name,
                    email: this.roleList[index].email,
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
                    id: this.roleList[index].id,
                    name: this.roleList[index].name,
                    roles: [],
                };

                this.roleList[index].roles.forEach(role => {
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

