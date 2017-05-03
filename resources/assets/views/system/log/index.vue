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

                    <div class="pull-right col-sm-6">
                        <div class="col-sm-4 input-group input-group-sm pull-right">
                            <input
                                    type="text"
                                    name="client_id"
                                    class="form-control"
                                    placeholder="IP"
                                    v-model="searchParams.client_id">

                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" @click.prevent="getResults">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-3 input-group input-group-sm pull-right margin-r-5">
                            <input
                                    type="text"
                                    name="user_id"
                                    class="form-control"
                                    placeholder="UserID"
                                    v-model="searchParams.user_id">
                        </div>
                        <div class="col-sm-3 input-group input-group-sm pull-right margin-r-5">
                            <select name="type" class="form-control" v-model="searchParams.type">
                                <option value="">选择类型</option>
                                <option value="created">created</option>
                                <option value="deleted">deleted</option>
                                <option value="restored">restored</option>
                                <option value="saved">saved</option>
                                <option value="updated">updated</option>
                                <option value="creating">creating</option>
                                <option value="deleting">deleting</option>
                                <option value="restoring">restoring</option>
                                <option value="saving">saving</option>
                                <option value="updating">updating</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                    <el-table :data="pageData.data"
                              v-loading="tableLoading">

                        <el-table-column
                                label="ID"
                                prop="id"
                                width="60">
                        </el-table-column>

                        <el-table-column
                                label="用户"
                                width="100">
                            <template scope="scope">
                                {{ scope.row.user == null ? 'guest' : scope.row.user.name }} / {{ scope.row.user_id }}
                            </template>

                        </el-table-column>

                        <el-table-column
                                label="类型"
                                prop="type"
                                width="90">
                        </el-table-column>

                        <el-table-column label="内容" prop="content">
                        </el-table-column>

                        <el-table-column
                                label="IP"
                                prop="client_ip"
                                width="120">
                        </el-table-column>

                        <el-table-column
                                label="客户端信息"
                                prop="client"
                                width="150">
                        </el-table-column>

                        <el-table-column
                                label="创建时间"
                                prop="created_at"
                                width="150">
                        </el-table-column>

                    </el-table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <el-pagination
                            layout="total, prev, pager, next"
                            :page-size="pageData.per_page"
                            @current-change="changePage"
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
                page: 1,

                searchParams: {
                    page: 1,
                    type: '',
                },
            }
        },
        computed: {
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            changePage(page) {
                this.searchParams.page = page;
                this.getResults();
            },
            getResults() {
                this.tableLoading = true;
                this.scoHttp('/admin/system/log/list', this.searchParams, response => {
                    this.tableLoading = false;
                    this.pageData = response.data;
                });
            },
            fetchData () {
                this.getResults();
            },
            add () {
                this.editModal = true;
                this.info = {
                    name: '',
                    email: '',
                    password: '',
                };
                this.errors = {};
            },
            edit (index) {
                this.editModal = true;
                this.info = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    email: this.pageData.data[index].email,
                    password: '',
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
//                            instance.confirmButtonText = '执行中...';
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

                this.errors = {};

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

