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
                                    <i class="ace-icon fa fa-plus bigger-120"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <b-table :columns="columns" :data="menuList">
                                <template slot="display_name" scope="props">
                                    <i v-html="props.row.spacer"></i> {{ props.row.display_name }}
                                </template>
                                <template slot="is_menu" scope="props">
                                    {{ props.row.is_menu ? '是' : '否' }}
                                </template>
                                <template slot="icon" scope="props">
                                    <i :class="['menu-icon', 'fa', props.row.icon]"></i>
                                </template>
                                <template slot="actions" scope="props">
                                    <div class="hidden-sm hidden-xs btn-group">
                                        <button class="btn btn-xs btn-info" @click.prevent="editMenu(props.row.id)">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </button>
                                        <button class="btn btn-xs btn-danger" @click.prevent="removeMenu(props.row.id)">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </button>
                                    </div>
                                </template>
                            </b-table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
            <Modal
                    v-model="editModal"
                    :title="modalTitle"
                    :loading="modalLoading"
                    @on-ok="saveMenu"
            >
                <form-dialog :info="info" :menuList="menuList" :errors="errors"></form-dialog>

            </Modal>
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

                columns: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    },
                    {
                        title: 'ID',
                        key: 'id'
                    },
                    {
                        title: '标题',
                        key: 'display_name',
                        class: 'col-sm-3',
                    },
                    {
                        title: '名称',
                        key: 'name'
                    },
                    {
                        title: '菜单',
                        key: 'is_menu',
                    },
                    {
                        title: '图标',
                        key: 'icon',
                    },
                    {
                        title: '排序',
                        key: 'sort',
                    },
                    {
                        title: '操作',
                        key: 'actions',
                        align: 'center',
                    }
                ],
                menuList: {}
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
                this.$loading.start();
                this.$http.get('/admin/system/menu/list').then(response => {
                    this.$loading.close();
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
                this.editModal = true;
                this.info = this.menuList[index];
                this.errors = {};
            },
            removeMenu (index) {
                this.$Modal.confirm({
                    title: '提示',
                    content: '确定要删除此菜单及其所有子菜单吗？',
                    loading: true,
                    onOk: () => {
                        this.$http.delete('/admin/system/menu/' + index)
                            .then((response) => {
                                this.$Modal.remove();
                                this.$Message.success('删除成功');
                                this.getResults();
                            }, (response) => {
                                console.log(response);
                                this.$Modal.remove();
                                this.$Message.error(response.data);
                            });
                    }
                });
            },
            saveMenu () {
                this.$loading.start();
                this.$http.post('/admin/system/menu/save', this.info)
                    .then((response) => {
                        console.log(response);
                        this.$loading.close();
                        this.editModal = false;
                        this.getResults();
                    }, (response) => {
                        this.$loading.close();
                        this.modalLoading = false;
                        setTimeout(() => {
                            this.modalLoading = true;
                        }, 300);

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

