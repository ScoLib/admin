<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="header pull-left">
                <ul class="nav nav-tabs padding-10 pull-left">
                    <li class="active">
                        <a data-toggle="tab" href="#" aria-expanded="true">
                            列表
                        </a>
                    </li>

                </ul>

                <ul class="pull-right right-btn">
                    <li><button type="button" class="btn btn-primary btn-xs" @click.prevent="addMenu">新建菜单</button></li>
                </ul>
            </div>

            <b-table :columns="columns" :data="menuList">
                <template slot="display_name" scope="props">
                    <i v-html="props.row.spacer"></i> {{ props.row.display_name }}
                </template>
                <template slot="icon" scope="props">
                    <i :class="['menu-icon', 'fa', props.row.icon]"></i>
                </template>
                <template slot="actions" scope="props">
                    <button type="button" class="btn btn-default btn-xs" @click.prevent="editMenu(props.row.id)">
                        <i class="fa fa-pencil"></i> 编辑
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" @click.prevent="removeMenu(props.row.id)">
                        <i class="fa fa-trash-o"></i> 删除
                    </button>
                </template>
            </b-table>

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
                this.$http.get('/admin/system/menu/list').then(response => {
                    this.menuList = response.data;
                });

            },
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.getResults();
            },
            addMenu () {
                this.editModal = true;
                this.info = {pid: 0, is_menu: 1};
            },
            editMenu (index) {
                this.editModal = true;
                this.info = this.menuList[index];
            },
            removeMenu (index) {
                console.log(this.data);
//                this.data.splice(index, 1);
            },
            saveMenu () {
                this.$loading.start();
                this.$http.post('/admin/system/menu/save', this.info).then((response) => {
                    console.log(response.data);
//                    this.editModal = false;
                }, (response) => {
                    this.errors = response.data;
                    this.$loading.close();
                    this.modalLoading = false;
                    setTimeout(() => {
                        this.modalLoading = true;
                    }, 300);
                });
//                this.getResults();
            }
        }
    }
</script>

