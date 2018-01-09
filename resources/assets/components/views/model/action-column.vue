<template>
    <div class="hidden-xs btn-group">
        <router-link
            v-if="config.accesses.edit && !row._deleted"
            class="btn btn-xs btn-info"
            :to="{name:'admin.model.edit', params:{model:$route.params.model,id:row._primary}}"
            :title="$t('sco.box.edit')">
            <i class="fa fa-pencil"></i>
        </router-link>
        <el-button
            v-if="config.accesses.delete && !row._deleted"
            class="btn btn-xs btn-danger margin-l-2"
            @click.prevent="deleteModel(row._primary)"
            :title="$t('sco.box.delete')">
            <i class="fa fa-trash-o"></i>
        </el-button>
        <el-button
            v-if="config.accesses.delete && row._deleted"
            class="btn btn-xs btn-danger margin-l-2"
            @click.prevent="destroyModel(row._primary)"
            :title="$t('sco.box.destroy')">
            <i class="fa fa-trash-o"></i>
        </el-button>
        <el-button
            v-if="row._deleted"
            class="btn btn-xs btn-warning margin-l-2"
            @click.prevent="restoreModel(row._primary)"
            :title="$t('sco.box.restore')">
            <i class="fa fa-reply"></i>
        </el-button>
    </div>
</template>

<script>
    import getConfig from '../../../mixins/get-config'

    export default {
        mixins: [
            getConfig
        ],
        data() {
            return {}
        },
        computed: {},
        props: {
            row: Object,
        },
        methods: {
            deleteModel(id) {
                this.$confirm(this.$t('sco.box.deleteConfirm', {content: this.config.title}),
                    this.$t('sco.box.confirmTitle'),
                    {
                        type: 'warning',
                        beforeClose: (action, instance, done) => {
                            if (action == 'confirm') {
                                instance.confirmButtonLoading = true;
                                this.$http.delete(
                                    `/${this.getUrlPrefix()}/${this.$route.params.model}/${id}/delete`
                                ).then(response => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                    this.$message.success(this.$t('sco.box.deleteSuccess'));
                                    this.$emit('change')
                                }).catch(error => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                })
                            } else {
                                done();
                            }
                        }
                    }).then(action => {
                }).catch(action => {
                });
            },
            destroyModel(id) {
                this.$confirm(this.$t('sco.box.destroyConfirm', {content: this.config.title}),
                    this.$t('sco.box.confirmTitle'),
                    {
                        type: 'warning',
                        beforeClose: (action, instance, done) => {
                            if (action == 'confirm') {
                                instance.confirmButtonLoading = true;
                                this.$http.delete(
                                    `/${this.getUrlPrefix()}/${this.$route.params.model}/${id}/destroy`
                                ).then(response => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                    this.$message.success(this.$t('sco.box.destroySuccess'));
                                    this.$emit('change')
                                }).catch(error => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                })
                            } else {
                                done();
                            }
                        }
                    }).then(action => {
                }).catch(action => {
                });
            },
            restoreModel(id) {
                this.$confirm(this.$t('sco.box.restoreConfirm', {content: this.config.title}),
                    this.$t('sco.box.confirmTitle'),
                    {
                        type: 'warning',
                        beforeClose: (action, instance, done) => {
                            if (action == 'confirm') {
                                instance.confirmButtonLoading = true;
                                this.$http.post(
                                    `/${this.getUrlPrefix()}/${this.$route.params.model}/${id}/restore`
                                ).then(response => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                    this.$message.success(this.$t('sco.box.restoreSuccess'));
                                    this.$emit('change')
                                }).catch(error => {
                                    instance.confirmButtonLoading = false;
                                    instance.close();
                                })
                            } else {
                                done();
                            }
                        }
                    }).then(action => {
                }).catch(action => {
                });
            }
        }
    }
</script>
