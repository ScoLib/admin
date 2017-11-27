<template>
    <div class="hidden-xs btn-group">
        <router-link
                v-if="config.accesses.edit && !row._deleted"
                class="btn btn-xs btn-info"
                :to="{name:'admin.model.edit', params:{model:$route.params.model,id:row._primary}}"
                title="编辑">
            <i class="fa fa-pencil"></i>
        </router-link>
        <el-button
                v-if="config.accesses.delete && !row._deleted"
                class="btn btn-xs btn-danger margin-l-2"
                @click.prevent="deleteModel(row._primary)"
                title="删除">
            <i class="fa fa-trash-o"></i>
        </el-button>
        <el-button
                v-if="config.accesses.delete && row._deleted"
                class="btn btn-xs btn-danger margin-l-2"
                @click.prevent="destroyModel(row._primary)"
                title="彻底删除">
            <i class="fa fa-trash-o"></i>
        </el-button>
        <el-button
                v-if="row._deleted"
                class="btn btn-xs btn-warning margin-l-2"
                @click.prevent="restoreModel(row._primary)"
                title="恢复">
            <i class="fa fa-reply"></i>
        </el-button>
    </div>
</template>

<script>
    import mixins from './mixins'

    export default {
        mixins: [
            mixins
        ],
        data() {
            return {}
        },
        computed: {

        },
        props: {
            row: Object,
        },
        methods: {
            deleteModel(id) {
                this.$confirm(`确定要删除此${this.config.title}吗？`, '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
                            this.$http.delete(
                                `/${this.getUrlPrefix()}/${this.$route.params.model}/${id}/delete`
                            ).then(response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('删除成功');
                                this.$emit('change')
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
            destroyModel(id) {
                this.$confirm(`确定要彻底删除此${this.config.title}吗？`, '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
                            this.$http.delete(
                                `/${this.getUrlPrefix()}/${this.$route.params.model}/${id}/destroy`
                            ).then(response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('删除成功');
                                this.$emit('change')
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
            restoreModel(id) {
                this.$confirm(`确定要恢复此${this.config.title}吗？`, '提示', {
                    type: 'warning',
                    beforeClose: (action, instance, done) => {
                        if (action == 'confirm') {
                            instance.confirmButtonLoading = true;
                            this.$http.post(
                                `/${this.getUrlPrefix()}/${this.$route.params.model}/${id}/restore`
                            ).then(response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('操作成功');
                                this.$emit('change')
                            }).catch(error => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                            })
                        } else {
                            done();
                        }
                    }
                }).then(action => {}).catch(action => {});
            }
        }
    }
</script>