<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary" @click.prevent="fetchData">
                            <i class="fa fa-refresh"></i>
                            刷新
                        </button>
                    </div>

                    <div class="btn-group btn-group-sm pull-right margin-r-5">
                        <button
                                type="button"
                                class="btn btn-default"
                                v-if="can('admin.users.user.store')"
                                @click.prevent="add">
                            <i class="fa fa-plus bigger-120"></i>
                            新建用户
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                    <el-table :data="pageData.data"
                              v-loading="tableLoading">

                        <el-table-column label="ID"
                                         prop="id"
                                         width="60">
                        </el-table-column>

                        <el-table-column label="名称" prop="name">
                        </el-table-column>

                        <el-table-column label="邮箱" prop="email">
                        </el-table-column>

                        <el-table-column label="创建时间" prop="created_at">
                        </el-table-column>

                        <el-table-column label="角色">
                            <template scope="scope">
                                <template v-for="role in scope.row.roles">
                                    {{ role.display_name }}[{{ role.name }}]<br>
                                </template>
                            </template>
                        </el-table-column>

                        <el-table-column
                                label="操作"
                                width="120"
                                align="center"
                                column-key="index">
                            <template scope="scope">
                                <div class="hidden-xs btn-group">
                                    <button class="btn btn-xs btn-info"
                                            v-if="can('admin.users.user.update')"
                                            @click.prevent="edit(scope.$index)"
                                            :disabled="cantEdit(scope.row)"
                                            title="编辑用户">
                                        <i class="fa fa-pencil bigger-120"></i>
                                    </button>
                                    <button class="btn btn-xs btn-danger"
                                            v-if="can('admin.users.user.destroy')"
                                            @click.prevent="destroy(scope.row.id)"
                                            :disabled="scope.row.id == 1"
                                            title="删除用户">
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
            <el-dialog :title="modalTitle" v-model="editModal">
                <b-form
                        :fields="editFields"
                        :info="info"
                        :errors="errors">
                    <div slot="role" v-loading="checkboxLoading">
                        <div class="checkbox" v-for="role in roleList">
                            <label>
                                <input
                                        :value="role.id"
                                        type="checkbox"
                                        v-model="info.roles">
                                {{ role.display_name }}
                            </label>
                        </div>
                    </div>
                </b-form>

                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="save" :loading="buttonLoading">确 定</el-button>
                </div>
            </el-dialog>

        </div>
    </div>
</template>

<script>

    export default {
        components: {
        },
        data() {
            return {
                editFields: [
                    {
                        key: 'name',
                        title: '用户名',
                    },
                    {
                        key: 'email',
                        title: 'Email',
                    },
                    {
                        key: 'password',
                        title: '密码',
                        type: 'password',
                    },
                    {
                        key: 'role',
                        title: '角色',
                        type: 'checkbox',
                    }
                ],

                // 编辑
                editModal: false,
                info: {},
                errors: {},

                // 列表
                tableLoading: false,
                pageData: {},

                buttonLoading: false,

                // 角色
                roleList: [],
                checkboxLoading: false,
            }
        },
        computed: {
            modalTitle () {
                return this.info.id ? '编辑用户' : '新建用户';
            },
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.tableLoading = true;
                this.$http.get('/admin/users/user/list', {params: {'page': page}})
                    .then(response => {
                        this.tableLoading = false;
                        this.pageData = response.data;
                    }).catch(error => {})
            },
            fetchData() {
                this.getResults();
            },
            getRoleList() {
                if (this.roleList.length == 0) {
                    this.checkboxLoading = true;
                    this.$http.get('/admin/users/user/role/all')
                        .then(response => {
                            this.roleList = response.data;
                            this.checkboxLoading = false;
                        });
                }
            },
            add() {
                this.editModal = true;
                this.info = {
                    name: '',
                    email: '',
                    password: '',
                    roles: [],
                };
                this.getRoleList();
                this.errors = {};
            },
            edit(index) {
                this.editModal = true;
                this.info = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    email: this.pageData.data[index].email,
                    password: '',
                    roles: [],
                };
                this.pageData.data[index].roles.forEach(role => {
                    this.info.roles.push(role.id);
                });
                this.getRoleList();
                this.errors = {};
            },
            save() {
                this.buttonLoading = true;
                if (typeof this.info.id == 'undefined') {
                    var url = '/admin/users/user/store';
                } else {
                    var url = '/admin/users/user/update';
                }
                this.$http.post(url, this.info)
                    .then(response => {
                        this.editModal = false;
                        this.buttonLoading = false;
                        this.getResults();
                    }).catch(error => {
                    this.buttonLoading = false;
                    if (typeof error.response.data == 'object') {
                        this.errors = error.response.data;
                    }
                })
            },
            destroy(id) {
                this.$confirm('确定要删除此管理员吗？', '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
//                            instance.confirmButtonText = '执行中...';
                            this.$http.delete('/admin/users/user/' + id)
                                .then(response => {
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
                });
            },
            cantEdit(row) {
                return row.id == 1 && this.$store.state.user.id != row.id;
            }
        }
    }
</script>

