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

                            <el-table :data="pageData.data" v-loading="tableLoading">
                                <el-table-column type="selection">
                                </el-table-column>

                                <el-table-column label="ID" prop="id" width="60">
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
                                            {{ role.name }}
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
                                                    @click.prevent="authorize(scope.$index)"
                                                    title="授权">
                                                <i class="fa fa-user-plus bigger-120"></i>
                                            </button>

                                            <button class="btn btn-xs btn-info"
                                                    @click.prevent="edit(scope.$index)"
                                                    title="编辑">
                                                <i class="fa fa-pencil bigger-120"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger"
                                                    @click.prevent="delete(scope.row.id)"
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
                            <!--<ul class="pagination pagination-sm no-margin pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">»</a></li>
                            </ul>-->
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
                    <el-button type="primary" @click="save" :loading="formLoading">确 定</el-button>
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

                editModal: false,
                info: {},
                modalLoading: true,
                errors: {},

                tableLoading: false,
                formLoading: false,
                pageData: {},
                selection: [],
            }
        },
        computed: {
            modalTitle: function () {
                return this.info.id ? '编辑管理员' : '新建管理员';
            },
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            getSelected (selection) {
                this.selection = selection;
            },
            getResults() {
                this.tableLoading = true;
                var _this = this;
                this.scoHttp('get', '/admin/manager/user/list', {}, function (response) {
                    this.tableLoading = false;
                    this.pageData = response.data;
                });
                /*this.scoHttp({
                    url: '/admin/manager/user/list',
                    method: 'get',
                }, function (response) {
                    this.tableLoading = false;
                    this.pageData = response.data;
                });*/
            },
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.getResults();
            },
            add () {
                this.editModal = true;
                this.info = {};
                this.errors = {};
            },
            edit (index) {
//                console.log(index);
//                console.log(this.userList[index]);
                this.editModal = true;
                this.info = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    email: this.pageData.data[index].email,
                };
                this.errors = {};
            },
            delete (id) {
                this.$confirm('确定要删除此管理员吗？', '提示',{
                    type: 'warning'
                }).then(() => {
                    this.$loading();
                    this.$http.delete('/admin/manager/user/' + id)
                        .then((response) => {
                            this.$loading().close();
                            this.$message.success('删除成功');
                            this.getResults();
                        }, (response) => {
                            this.$loading().close();
//                                console.log(response);
                            this.$message.error(response.data);
                        });
                }).catch(() => {});
            },
            save () {
                this.formLoading = true;
                this.scoHttp('post', '/admin/manager/user/save', this.info, (response) => {
                    this.editModal = false;
                    this.formLoading = false;
                    this.getResults();
                });
            },
            authorize () {
                this.scoHttp('get', '/admin/manager/user/authorize', {}, (response) => {

                });
            }
        }
    }
</script>

