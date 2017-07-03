export default {
    data() {
        return {
        }
    },
    computed: {
        isActionColumn() {
            var permissions = this.config.permissions;
            return permissions.edit || permissions.delete || permissions.restore;
        }
    },
    methods: {
        getActionButtons(h, row) {
            var buttons = [], permissions = this.config.permissions;
            if (permissions.edit && !row._deleted) {
                var link = {
                    name:'admin.model.edit',
                    params:{
                        model:this.$route.params.model,
                        id:row[this.config.primaryKey]
                    }
                };
                buttons.push(
                    <router-link class="btn btn-xs btn-info"
                                 to={link}
                                 title="编辑">
                        <i class="fa fa-pencil bigger-120"></i>
                    </router-link>
                );
            }

            if (permissions.delete && !row._deleted) {
                let deleteFnc = () => {
                    this.delete(row[this.config.primaryKey])
                };
                buttons.push(
                    <el-button class="btn btn-xs btn-danger margin-l-2"
                            onClick={deleteFnc} title="删除">
                        <i class="fa fa-trash-o bigger-120"></i>
                    </el-button>
                );
            }

            if (permissions.delete && row._deleted) {
                let destroy = () => {
                    this.destroy(row[this.config.primaryKey])
                };
                buttons.push(
                    <el-button class="btn btn-xs btn-danger margin-l-2"
                            onClick={destroy} title="彻底删除">
                        <i class="fa fa-trash-o bigger-120"></i>
                    </el-button>
                );
            }

            if (row._deleted) {
                let restore = () => {
                    this.restore(row[this.config.primaryKey])
                };
                buttons.push(
                    <el-button class="btn btn-xs btn-warning margin-l-2"
                            onClick={restore} title="恢复">
                        <i class="fa fa-reply bigger-120"></i>
                    </el-button>
                );
            }
            return buttons;
        },
        delete(id) {
            this.$confirm(`确定要删除此${this.config.title}吗？`, '提示', {
                type: 'warning',
                beforeClose: (action, instance, done) => {
                    if (action == 'confirm') {
                        instance.confirmButtonLoading = true;
                        this.$http.delete(`/${this.urlPrefix}/${this.$route.params.model}/${id}/delete`)
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

            /*this.$Modal.confirm({
                title: '提示',
                content: `确定要删除此${this.config.title}吗？`,
                loading: true,
                onOk: () => {
                    this.$http.delete(`/${this.urlPrefix}/${this.$route.params.model}/${id}/delete`)
                        .then(response => {
                            this.$Modal.remove();
                            this.$Message.success('删除成功');
                            this.getResults();
                        }).catch(error => {
                            this.$Modal.remove();
                        })
                }
            });*/
        },
        destroy(id) {
            this.$confirm(`确定要彻底删除此${this.config.title}吗？`, '提示', {
                type: 'warning',
                beforeClose: (action, instance, done) => {
                    if (action == 'confirm') {
                        instance.confirmButtonLoading = true;
                        this.$http.delete(`/${this.urlPrefix}/${this.$route.params.model}/${id}/destroy`)
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

            /*this.$Modal.confirm({
                title: '提示',
                content: `确定要彻底删除此${this.config.title}吗？`,
                loading: true,
                onOk: () => {
                    this.$http.delete(`/${this.urlPrefix}/${this.$route.params.model}/${id}/destroy`)
                        .then(response => {
                            this.$Modal.remove();
                            this.$Message.success('删除成功');
                            this.getResults();
                        }).catch(error => {
                            this.$Modal.remove();
                        })
                }
            });*/
        },
        restore(id) {
            this.$confirm(`确定要恢复此${this.config.title}吗？`, '提示', {
                type: 'warning',
                beforeClose: (action, instance, done) => {
                    if (action == 'confirm') {
                        instance.confirmButtonLoading = true;
                        this.$http.post(`/${this.urlPrefix}/${this.$route.params.model}/${id}/restore`)
                            .then(response => {
                                instance.confirmButtonLoading = false;
                                instance.close();
                                this.$message.success('操作成功');
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

            /*this.$Modal.confirm({
                title: '提示',
                content: `确定要恢复此${this.config.title}吗？`,
                loading: true,
                onOk: () => {
                    this.$http.post(`/${this.urlPrefix}/${this.$route.params.model}/${id}/restore`)
                        .then(response => {
                            this.$Modal.remove();
                            this.$Message.success('操作成功');
                            this.getResults();
                        }).catch(error => {
                        this.$Modal.remove();
                    })
                }
            });*/
        }
    }
}