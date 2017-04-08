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
                                <button type="button" class="btn btn-success btn-xs" @click.prevent="addMenu">
                                    <i class="fa fa-plus bigger-120"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">

                            <el-table :data="menuList" v-loading="tableLoading">
                                <el-table-column type="selection">
                                </el-table-column>

                                <el-table-column label="ID" prop="id" width="60">
                                </el-table-column>

                                <el-table-column label="显示名称">
                                    <template scope="scope">
                                        <span v-html="scope.row.spacer"></span> {{ scope.row.display_name }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="名称" prop="name">
                                </el-table-column>

                                <el-table-column label="菜单">
                                    <template scope="scope">
                                        {{ scope.row.is_menu ? '是' : '否' }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="图标">
                                    <template scope="scope">
                                        <i :class="['menu-icon', 'fa', scope.row.icon]"></i>
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="操作"
                                        width="120"
                                        align="center"
                                        column-key="index">
                                    <template scope="scope">
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <button class="btn btn-xs btn-info" @click.prevent="editMenu(scope.$index)">
                                                <i class="fa fa-pencil bigger-120"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger" @click.prevent="removeMenu(scope.row.id)">
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
                        </div>
                    </div>


                </div>
            </div>
            <el-dialog :title="modalTitle" v-model="editModal">
                <form-dialog :info="info" :menuList="menuList" :errors="errors"></form-dialog>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="saveMenu" :loading="formLoading">确 定</el-button>
                </div>
            </el-dialog>

            <!--<Modal
                    v-model="editModal"
                    :title="modalTitle"
                    :loading="modalLoading"
                    @on-ok="saveMenu"
            >
                <form-dialog :info="info" :menuList="menuList" :errors="errors"></form-dialog>

            </Modal>-->
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
                title: '菜单管理',
                breads: [
                    {
                        'url': '',
                        'title': '系统管理',
                    }
                ],

                editModal: false,
                info: {},
                modalLoading: true,
                errors: {},

                tableLoading: false,
                formLoading: false,
                menuList: [],
                selection: [],
            }
        },
        computed: {
            modalTitle: function () {
                return this.info.id ? '编辑菜单' : '新建菜单';
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
//                this.$loading.start();
                this.tableLoading = true;
                this.$http.get('/admin/system/menu/list').then(response => {
                    this.tableLoading = false;
//                    this.$loading.close();
                    this.menuList = response.data;
                });

            },
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.getResults();
            },
            addMenu () {
                this.editModal = true;
                this.info = {pid: 0, is_menu: 1, sort: 255};
                this.errors = {};
            },
            editMenu (index) {
//                console.log(index);
//                console.log(this.menuList[index]);
                this.editModal = true;
                this.info = this.menuList[index];
                this.errors = {};
            },
            removeMenu (id) {
                this.$confirm('确定要删除此菜单及其所有子菜单吗？', '提示',{
                    type: 'warning'
                }).then(() => {
                    this.$loading();
                    this.$http.delete('/admin/system/menu/' + id)
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
            saveMenu () {
                this.formLoading = true;
//                this.$loading.start();
                this.$http.post('/admin/system/menu/save', this.info)
                    .then((response) => {
                        console.log(response);
//                        this.$loading.close();
                        this.editModal = false;
                        this.formLoading = false;
                        this.getResults();
                    }, (response) => {
//                        this.$loading.close();

                        this.formLoading = false;
                        if (typeof response.data == 'object') {
                            this.errors = response.data;
                        } else {
                            this.$Message.error(response.statusText);
                        }
                    });
            }
        }
    }
</script>

