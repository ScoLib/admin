<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clearfix">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default">批量操作</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
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

                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary" @click.prevent="fetchData">
                            <i class="fa fa-refresh"></i>
                            刷新
                        </button>
                    </div>


                    <div class="btn-group btn-group-sm pull-right margin-r-5">
                        <button type="button" class="btn btn-default" @click.prevent="add">
                            <i class="fa fa-plus bigger-120"></i>
                            创建角色
                        </button>
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
                                    <button class="btn btn-xs btn-info" @click.prevent="edit(scope.$index)">
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

            <el-dialog :title="modalTitle" v-model="editModal" @open="handleOpen()">
                <b-form
                        :fields="fields"
                        :info="info"
                        :errors="errors">
                    <el-tree
                            :data="permissionList"
                            show-checkbox
                            node-key="id"
                            ref="tree"
                            slot="perms">
                    </el-tree>
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
                // 编辑
                editModal: false,
                info: {},
                errors: {},

                // 列表
                tableLoading: false,
                pageData: {},

                selection: [],
                buttonLoading: false,

                // 角色
                permissionList: [],

                // el-tree

            }
        },
        computed: {
            modalTitle () {
                return this.info.id ? this.$t('form.edit_role') : this.$t('form.create_role');
            },
            fields() {
                return [
                    {
                        key: 'name',
                        title: this.$t('table.name'),
                    },
                    {
                        key: 'display_name',
                        title: this.$t('table.display_name'),
                    },
                    {
                        key: 'perms',
                        title: '授权',
                    }
                ];
            },
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            fetchData () {
                this.getResults();
            },
            handleOpen() {
                this.$nextTick(() => {
                    let keys = [];
                    if (this.info.perms.length > 0) {
                        keys = this.parseCheckedPermission(this.permissionList);
                    }
                    this.$refs.tree.setCheckedKeys(keys);
                });
            },
            // 处理需要设置为选中的节点（移除半选中节点，只保留最深层的）
            parseCheckedPermission(perms) {
                let list = [];
                Object.keys(perms).forEach(index => {
                    if (this.info.perms.indexOf(perms[index].id) > -1) {
                        if (Object.keys(perms[index].children).length > 0) {
                            list = list.concat(this.parseCheckedPermission(perms[index].children));
                        } else {
                            list.push(perms[index].id);
                        }
                    }
                });
                return list;
            },
            selectable(row, index) {
                return row.id == 1 ? false : true;
            },
            getSelected(selection) {
                this.selection = [];
                selection.forEach(row => {
                    this.selection.push(row.id);
                });
            },
            getResults() {
                this.tableLoading = true;

                this.getPermissionList();

                this.scoHttp('/admin/manager/role/list', response => {
                    this.tableLoading = false;
                    this.pageData = response.data;
                });

            },
            getPermissionList() {
                this.scoHttp('/admin/manager/role/perms/list', response => {
                    this.permissionList = this.parsePermissionTree(response.data);
                });
            },
            parsePermissionTree(perms) {
                let list = [];
                Object.keys(perms).forEach(index => {
                    let children = [];
                    if (Object.keys(perms[index].child).length > 0) {
                        children = this.parsePermissionTree(perms[index].child);
                    }
                    list.push({
                        id: perms[index].id,
                        label: perms[index].display_name,
                        children: children,
                    });
                });
                return list;
            },
            add() {
                this.editModal = true;
                this.info = {
                    perms: []
                };
                this.errors = {};
            },
            edit(index) {
                this.editModal = true;
                this.info = {
                    id: this.pageData.data[index].id,
                    name: this.pageData.data[index].name,
                    display_name: this.pageData.data[index].display_name,
                    perms: [],
                };

                this.pageData.data[index].perms.forEach(perm => {
                    this.info.perms.push(perm.id);
                });

                this.errors = {};
            },
            remove (id) {
                this.$confirm('确定要删除此角色吗？', '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            this.MessageBoxInstance = instance;

                            instance.confirmButtonLoading = true;
                            this.scoHttp('delete', '/admin/manager/role/' + id, response => {
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
            save() {
                this.info.perms = this.getCheckedPermission();

                this.buttonLoading = true;
                this.scoHttp('post', '/admin/manager/role/save', this.info, response => {
                    this.editModal = false;
                    this.buttonLoading = false;
                    this.getResults();
                });
            },
            // 获取选中的节点（包括半选中节点）
            getCheckedPermission() {
                let keys = this.$refs.tree.getCheckedKeys();
                let nodesDOM = this.$refs.tree.$el.querySelectorAll('.el-tree-node');
                let nodesVue = [].map.call(nodesDOM, node => node.__vue__);
                nodesVue.filter(item => item.indeterminate === true).forEach(_vue => {
                    keys.push(_vue.node.data.id);
                });
                return keys;
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
//                            instance.confirmButtonText = '执行中...';

                            this.scoHttp('post', '/admin/manager/role/batch/delete', {'ids': this.selection}, response => {
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

