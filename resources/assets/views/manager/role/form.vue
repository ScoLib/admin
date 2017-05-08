<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box" v-loading="loading">
                <div class="box-header clearfix">
                    <h3 class="box-title">{{ title }}</h3>

                    <div class="btn-group btn-group-sm pull-right margin-r-5">
                        <button type="button" class="btn btn-default" @click.prevent="$router.go(-1)">
                            <i class="fa fa-reply bigger-120"></i>
                            {{ $t('form.back') }}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <b-form
                        :fields="fields"
                        :info="info"
                        :errors="errors">
                    <el-tree
                            :data="permissionList"
                            show-checkbox
                            node-key="id"
                            ref="tree"
                            default-expand-all
                            slot="perms">
                    </el-tree>
                </b-form>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">{{ $t('form.ok') }}</button>
                </div>
                <!-- /.box-footer -->
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                info: {},
                errors: {},
                permissionList: [],
            }
        },
        computed: {
            title () {
                return this.$route.name == 'admin.manager.role.edit'
                    ? this.$t('form.edit_role')
                    : this.$t('form.create_role');
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
        methods: {
            fetchData () {
                if (this.$route.name == 'admin.manager.role.edit' && this.$route.params.id) {
                    this.scoHttp('/admin/manager/role/'+ this.$route.params.id, response => {
                        this.info = {
                            id: response.data.id,
                            name: response.data.name,
                            display_name: response.data.display_name,

                        };
                    });
                }
                this.getPermissionList();
            },
            getPermissionList() {
                this.scoHttp('/admin/manager/role/perms/list', response => {
                    this.permissionList = this.parsePermissionTree(response.data);
                    this.loading = false;
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
        }

    }
</script>