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
                        <button type="button" class="btn btn-default" @click.prevent="add">
                            <i class="fa fa-plus bigger-120"></i>
                            创建管理员
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

                        <el-table-column label="管理组">
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
                                            @click.prevent="setRole(scope.$index)"
                                            :disabled="scope.row.id == 1"
                                            title="设置角色">
                                        <i class="fa fa-user-plus bigger-120"></i>
                                    </button>

                                    <button class="btn btn-xs btn-info"
                                            @click.prevent="edit(scope.$index)"
                                            title="编辑管理员">
                                        <i class="fa fa-pencil bigger-120"></i>
                                    </button>
                                    <button class="btn btn-xs btn-danger"
                                            @click.prevent="remove(scope.row.id)"
                                            :disabled="scope.row.id == 1"
                                            title="删除管理员">
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
                </b-form>

                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="save" :loading="buttonLoading">确 定</el-button>
                </div>
            </el-dialog>

            <el-dialog title="设置角色" v-model="setRoleModal">

                <b-form
                        :fields="roleFields"
                        :info="roleData"
                        :errors="errors">
                    <input type="text"
                           class="form-control"
                           :value="roleData.name"
                           disabled
                           slot="name">

                    <div slot="role" v-loading="checkboxLoading">
                        <div class="checkbox" v-for="role in roleList">
                            <label>
                                <input
                                        :value="role.id"
                                        type="checkbox"
                                        v-model="roleData.roles">
                                {{ role.display_name }}
                            </label>
                        </div>
                    </div>

                </b-form>

                <div slot="footer" class="dialog-footer">
                    <el-button @click="setRoleModal = false">取 消</el-button>
                    <el-button type="primary" @click="saveRole" :loading="buttonLoading">确 定</el-button>
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
                        title: '管理员名称',
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
                ],

                roleFields: [
                    {
                        key: 'name',
                        title: '管理员名称',
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
                setRoleModal: false,
                roleData: {},
                roleList: [],
                checkboxLoading: false,
            }
        },
        computed: {
            modalTitle () {
                return this.info.id ? '编辑管理员' : '新建管理员';
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
            add() {
                this.editModal = true;
                this.info = {
                    name: '',
                    email: '',
                    password: '',
                };
                this.errors = {};
            },
            edit(index) {
                this.editModal = true;
                this.info = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    email: this.pageData.data[index].email,
                    password: '',
                };
                this.errors = {};
            },
            remove(id) {
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
            save() {
                this.buttonLoading = true;
                this.$http.post('/admin/users/user/save', this.info)
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
            setRole(index) {
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

                this.errors = {};
                if (this.roleList.length == 0) {
                    this.checkboxLoading = true;
                    this.$http.get('/admin/users/user/role/all')
                        .then(response => {
                            this.roleList = response.data;
                            this.checkboxLoading = false;
                        });
                }
            },
            saveRole () {
                this.buttonLoading = true;
                this.$http.post('/admin/users/user/save/role', this.roleData)
                    .then(response => {
                        this.setRoleModal = false;
                        this.buttonLoading = false;
                        this.getResults();
                    }).catch(error => {
                        this.setRoleModal = false;
                        this.buttonLoading = false;
                    })
            }
        }
    }
</script>

