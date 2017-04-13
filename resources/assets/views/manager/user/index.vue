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
                                        <a href="#">Action</a>
                                    </li>

                                    <li>
                                        <a href="#">Another action</a>
                                    </li>

                                    <li>
                                        <a href="#">Something else here</a>
                                    </li>

                                    <li class="divider"></li>

                                    <li>
                                        <a href="#">Separated link</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-success btn-xs" @click.prevent="add">
                                    <i class="fa fa-plus bigger-120"></i></button>
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
                                                    title="角色">
                                                <i class="fa fa-user-plus bigger-120"></i>
                                            </button>

                                            <button class="btn btn-xs btn-info"
                                                    @click.prevent="edit(scope.$index)"
                                                    title="编辑">
                                                <i class="fa fa-pencil bigger-120"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger"
                                                    @click.prevent="remove(scope.row.id)"
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

            <el-dialog title="设置角色" v-model="setRoleModal">
                <div class="form-horizontal">

                    <form-group name="name" title="管理员名称">
                        <input type="text"
                               class="col-xs-12 col-sm-9"
                               :value="roleData.name" disabled>
                    </form-group>

                    <div class="space-2"></div>

                    <form-group name="role" title="角色">
                            <div v-for="role in roleList">
                                <label>
                                    <input name="role[]" :value="role.id" type="checkbox" class="ace" v-model="roleData.roles">
                                    <span class="lbl"> {{ role.display_name }}</span>
                                </label>
                            </div>
                    </form-group>

                    <input type="hidden" name="id" v-model="roleData.id">
                </div>

                <div slot="footer" class="dialog-footer">
                    <el-button @click="setRoleModal = false">取 消</el-button>
                    <el-button type="primary" @click="saveRole" :loading="buttonLoading">确 定</el-button>
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
                title: '管理员',
                breads: [
                    {
                        'url': '',
                        'title': '管理组',
                    }
                ],

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
                return this.info.id ? '编辑管理员' : '新建管理员';
            },
            roles () {
                let roles = [];
                if (typeof this.info.roles != 'undefined') {
                    this.info.roles.forEach(role => {
                        roles.push(role.id);
                    });
                }
                return roles;
            }
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            selectable (row, index) {
                return row.id == 1 ? false : true;
            },
            getSelected (selection) {
                console.log(selection);
                this.selection = selection;
            },
            getResults() {
                this.tableLoading = true;
                this.scoHttp('/admin/manager/user/list', response => {
                    this.tableLoading = false;
                    this.pageData = response.data;
                });
            },
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.getResults();

                this.scoHttp('/admin/manager/role/list', response => {
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
                        this.MessageBoxInstance = instance;

                        instance.confirmButtonLoading = true;
                        instance.confirmButtonText = '执行中...';
                        this.scoHttp('delete', '/admin/manager/user/' + id, response => {
                            instance.close();
                            instance.confirmButtonLoading = false;
                            this.$message.success('删除成功');
                            this.getResults();
                        });
                    }
                });
            },
            save () {
                this.buttonLoading = true;
                this.scoHttp('post', '/admin/manager/user/save', this.info, response => {
                    this.editModal = false;
                    this.buttonLoading = false;
                    this.getResults();
                });
            },
            setRole (index) {
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
            }
        }
    }
</script>

