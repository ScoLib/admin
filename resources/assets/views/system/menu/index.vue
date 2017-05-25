<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default">批量操作</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#" @click.prevent="batchRemove">
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
                        <button type="button" class="btn btn-default" @click.prevent="add">
                            <i class="fa fa-plus bigger-120"></i>
                            创建菜单
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <el-table :data="menuList"
                              v-loading="tableLoading"
                              @selection-change="getSelected">

                        <el-table-column
                                type="selection">
                        </el-table-column>

                        <el-table-column label="ID" prop="id" width="60">
                        </el-table-column>

                        <el-table-column label="显示名称">
                            <template scope="scope">
                                <el-popover trigger="hover" placement="top" v-if="scope.row.description">
                                    <span>{{ scope.row.description }}</span>
                                    <div slot="reference" class="name-wrapper">
                                        <span v-html="scope.row.spacer"></span> {{ scope.row.display_name }}
                                    </div>
                                </el-popover>

                                <template v-else>
                                    <span v-html="scope.row.spacer"></span> {{ scope.row.display_name }}
                                </template>
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
                                    <button
                                            class="btn btn-xs btn-info"
                                            title="编辑菜单"
                                            @click.prevent="edit(scope.$index)">
                                        <i class="fa fa-pencil bigger-120"></i>
                                    </button>
                                    <button
                                            class="btn btn-xs btn-danger"
                                            title="删除菜单"
                                            @click.prevent="remove(scope.row.id)">
                                        <i class="fa fa-trash-o bigger-120"></i>
                                    </button>
                                </div>
                            </template>
                        </el-table-column>

                    </el-table>
                </div>
                <!-- /.box-body -->
            </div>

            <el-dialog :title="modalTitle" v-model="editModal">
                <b-form
                        :fields="formFields"
                        :info="info"
                        :errors="errors">
                    <select
                            class="form-control"
                            name="pid"
                            slot="pid"
                            v-model="info.pid">
                        <option value="0">顶级菜单</option>
                        <option
                                :value="menu.id"
                                v-for="menu in menuList">
                            <i v-html="menu.spacer"></i>{{menu.display_name}}
                        </option>


                    </select>

                    <input type="text" data-toggle="tooltip"
                           data-original-title="必须是路由的别名，如不是链接，则填“#”"
                            name="name" class="form-control"
                           placeholder="admin.system.menu"
                           slot="name"
                           v-model="info.name">
                </b-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="saveMenu" :loading="buttonLoading">确 定</el-button>
                </div>
            </el-dialog>

        </div>
    </div>
</template>

<script>

    export default {
        components: {
        },
        data: function () {
            return {
                // 编辑
                editModal: false,
                info: {},
                errors: {},

                // 列表
                tableLoading: false,
                menuList: [],

                selection: [],
                buttonLoading: false,

            }
        },
        computed: {
            modalTitle () {
                return this.info.id ? '编辑菜单' : '新建菜单';
            },
            formFields () {
                return [
                    {
                        key: 'pid',
                        title: '父级菜单',
                        type: 'select',
                    },
                    {
                        key: 'display_name',
                        title: '显示名称',
                    },
                    {
                        key: 'name',
                        title: '菜单标识',
                        type: 'text',
                    },
                    {
                        key: 'icon',
                        title: '菜单图标',
                        type: 'text',
                    },
                    {
                        key: 'is_menu',
                        title: '显示菜单',
                        type: 'radio',
                        options: [
                            {
                                value: 1,
                                label: '是',
                            },
                            {
                                value: 0,
                                label: '否',
                            }
                        ],
                    },
                    {
                        key: 'sort',
                        title: '排序',
                        type: 'number',
                    },
                    {
                        key: 'description',
                        title: '描述',
                        type: 'textarea',
                        rows: 3
                    },
                ];
            }
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            getSelected(selection) {
                this.selection = [];
                selection.forEach(row => {
                    this.selection.push(row.id);
                });
            },
            getResults() {
                this.tableLoading = true;
                this.$http.get('/admin/system/menu/list')
                    .then(response => {
                        this.tableLoading = false;
                        this.menuList = response.data;
                    }).catch(error => {})
            },
            fetchData() {
                this.getResults();
            },
            add() {
                this.editModal = true;
                this.info = {pid: 0, is_menu: 1, sort: 255};
                this.errors = {};
            },
            edit(index) {
//                console.log(index);
//                console.log(this.menuList[index]);
                this.editModal = true;
                this.info = this.menuList[index];
                this.errors = {};
            },
            remove(id) {
                this.$confirm('确定要删除此菜单及其所有子菜单吗？', '提示',{
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
//                            instance.confirmButtonText = '执行中...';
                            this.$http.delete('/admin/system/menu/' + id)
                                .then(response => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                    this.$message.success('删除成功');
                                    this.getResults();
                                }).catch(error => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                });
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});
            },
            batchRemove() {
                if (this.selection.length == 0) {
                    this.$message.error('请选择操作对象');
                    return false;
                }

                this.$confirm('确定要删除此菜单及其所有子菜单吗？', '提示',{
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
//                            instance.confirmButtonText = '执行中...';
                            this.$http.post('/admin/system/menu/batch/delete', {'ids': this.selection})
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
                }).then(action => {}).catch(action => {});
            },
            saveMenu() {
                this.buttonLoading = true;
                this.$http.post('/admin/system/menu/save', this.info)
                    .then(response => {
                        this.editModal = false;
                        this.buttonLoading = false;
                        this.getResults();
                    }).catch(error => {
                        this.buttonLoading = false;
                        if (typeof error.response.data == 'object') {
                            this.errors = error.response.data;
                        }
                    });
            }
        }
    }
</script>

