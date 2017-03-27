<template>
    <div class="row">
        <div class="col-xs-12">
            <button type="button" class="btn btn-default btn-xs" @click.prevent="add">新建菜单</button>
            <b-table :columns="columns" :data="data">
                <template slot="display_name" scope="props">
                    <i v-html="props.row.spacer"></i> {{ props.row.display_name }}
                </template>
                <template slot="icon" scope="props">
                    <i :class="['menu-icon', 'fa', props.row.icon]"></i>
                </template>
                <template slot="actions" scope="props">
                    <button type="button" class="btn btn-default btn-xs" @click.prevent="edit(props.row.id)">
                        <i class="fa fa-pencil"></i> 编辑
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" @click.prevent="remove(props.row.id)">
                        <i class="fa fa-trash-o"></i> 删除
                    </button>
                </template>
            </b-table>

            <Modal
                    v-model="editModal"
                    :title="modalTitle"
                    :loading="loading"
                    @on-ok="saveMenu"
            >
                <div class="profile-user-info">

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 父级菜单 </div>

                        <div class="profile-info-value">
                            <select class="form-control" name="pid">
                                <option value="0">顶级菜单</option>

                                <option value="1">11222</option>
                            </select>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> 显示名称 </div>

                        <div class="profile-info-value">
                            <input class="form-control" type="text" name="title" v-model="info.display_name">
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 名称 </div>

                        <div class="profile-info-value">
                            <input type="text" data-toggle="tooltip"
                                   data-original-title="必须是路由的别名，如不是链接，则填“#”" name="name" class="form-control tooltips" placeholder="admin.system.menu" v-model="info.name">
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> 图标 </div>

                        <div class="profile-info-value">
                            <input type="text" name="icon" class="form-control"
                                   placeholder="fa-" v-model="info.icon">
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 菜单 </div>

                        <div class="profile-info-value">
                            <div class="switch">
                                <input type="radio" class="switch-input" name="is_menu" value="1" id="is_menu_on" checked>
                                <label for="is_menu_on" class="switch-label switch-label-on">是</label>
                                <input type="radio" class="switch-input" name="is_menu" value="0" id="is_menu_off">
                                <label for="is_menu_off" class="switch-label switch-label-off">否</label>
                                <span class="switch-selection"></span>

                            </div>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 排序 </div>

                        <div class="profile-info-value">
                            <input type="text" name="sort" data-toggle="tooltip"
                                   data-original-title="数字：0~255" class="form-control tooltips" v-model="info.sort">
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 描述 </div>

                        <div class="profile-info-value">
                            <textarea id="description" class="form-control" rows="3" name="description" v-model="info.description"></textarea>
                        </div>
                    </div>

                </div>
            </Modal>
        </div>
    </div>
</template>

<script>

    export default {
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
                loading: true,
                info: {},
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
                data: {}
            }
        },
        computed: {
            modalTitle: function () {
                return this.info.id ? '编辑菜单' : '新建菜单';
            }
        },
        created () {
            this.fetchData();
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.$http.get('/admin/system/menu/list').then(response => {
                    this.data = response.data;
                })

            },
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.getResults(1);

            },
            add () {
                this.editModal = true;
                this.info = {};
            },
            edit (index) {
                this.editModal = true;
                this.info = this.data[index];
            },
            remove (index) {
                console.log(this.data);
                this.data.splice(index, 1);
            },
            saveMenu () {
                console.log(this.info);
                this.editModal = false;
            }
        }
    }
</script>

