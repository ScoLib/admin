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
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-success btn-xs" @click.prevent="addMenu">
                                    <i class="fa fa-plus bigger-120"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">

                            <el-table :data="menuList" v-loading="tableLoading">

                                <el-table-column label="ID" prop="id" width="60">
                                </el-table-column>

                                <el-table-column label="显示名称">
                                    <template scope="scope">
                                        <span v-html="scope.row.spacer"></span> {{ scope.row.display_name }}
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="名称"
                                        prop="name"
                                        class-name="hidden-xs">
                                </el-table-column>

                                <el-table-column
                                        label="菜单"
                                        width="70">
                                    <template scope="scope">
                                        {{ scope.row.is_menu ? '是' : '否' }}
                                    </template>
                                </el-table-column>

                                <el-table-column
                                        label="图标"
                                        width="70"
                                        class-name="hidden-xs">
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
                                        <div class=" btn-group">
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
                    </div>


                </div>
            </div>
            <el-dialog :title="modalTitle" v-model="editModal">
                <form-dialog :info="info" :menuList="menuList" :errors="errors"></form-dialog>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="saveMenu" :loading="buttonLoading">确 定</el-button>
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
                buttonLoading: false,
                menuList: [],
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
            getResults() {
                this.tableLoading = true;
                this.scoHttp('/admin/system/menu/list', response => {
                    this.tableLoading = false;
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
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        this.MessageBoxInstance = instance;

                        instance.confirmButtonLoading = true;
                        instance.confirmButtonText = '执行中...';
                        this.scoHttp('delete', '/admin/system/menu/' + id, response => {
                            instance.close();
                            instance.confirmButtonLoading = false;
                            this.$message.success('删除成功');
                            this.getResults();
                        });
                    }
                });
            },
            saveMenu () {
                this.buttonLoading = true;
                this.scoHttp('post', '/admin/system/menu/save', this.info, response => {
                    this.editModal = false;
                    this.buttonLoading = false;
                    this.getResults();
                });
            }
        }
    }
</script>

