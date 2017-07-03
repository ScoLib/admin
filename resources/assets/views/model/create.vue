<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clearfix">
                    <h3 class="box-title">创建 {{ config.title }}</h3>

                    <div class="btn-group btn-group-sm pull-right margin-r-5">
                        <button
                                type="button"
                                class="btn btn-default"
                                @click.prevent="$router.push({ name: 'admin.model.index', params: {model: $route.params.model}})">
                            <i class="fa fa-reply bigger-120"></i>
                            {{ $t('form.back') }}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <v-form
                        :fields="fields"
                        v-model="info"
                        :errors="errors">
                </v-form>

                <!-- /.box-body -->
                <div class="box-footer">
                    <el-button type="primary" @click="save" :loading="buttonLoading">{{ $t('form.ok') }}</el-button>
                </div>
                <!-- /.box-footer -->
            </div>

        </div>
    </div>
</template>

<script>
    import vForm from '../../components/Form.vue';

    export default {
        components: {
            vForm
        },
        data() {
            return {
                test: '',
//                info: {},
                errors: {},
                buttonLoading: false,
            }
        },
        computed: {
            config() {
                let models = this.$store.state.models;
                let model = this.$route.params.model;
//                console.log(models[model]);
//                console.log(model);
//                console.log(Object.keys(models).indexOf(model));
                if (Object.keys(models).indexOf(model) == -1) {
                    return {};
                } else {
//                    console.log(models[model]);
                    return models[model];
                }
            },
            info() {
                let info = {};
                this.fields.forEach(field => {
                    info[field.key] = '';
                    if (field.type == 'checkbox') {
                        info[field.key] = [];
                    }
                });
//                console.log(info);
                return info;
            },
            fields() {
                return [
                    {
                        key: 'input',
                        title: 'Input',
                    },
                    {
                        key: 'password',
                        title: 'password',
                        type: 'password',
                    },
                    {
                        key: 'textarea',
                        title: 'textarea',
                        type: 'textarea',
                    },
                    {
                        key: 'radio',
                        title: 'radio',
                        type: 'radio',
                        options: [
                            {
                                value: '1',
                                label: '值1',
                            },
                            {
                                value: '2',
                                label: 'V2',
                            },
                            {
                                value: '3',
                                label: 'V3',
                            }
                        ],
                    },
                    {
                        key: 'checkbox',
                        title: 'checkbox',
                        type: 'checkbox',
                        options: [
                            {
                                value: '1',
                                label: '值1',
                            },
                            {
                                value: '2',
                                label: 'V2',
                            },
                            {
                                value: '3',
                                label: 'V3',
                            }
                        ],
                    }
                ];
            },
            urlPrefix() {
                return this.$store.state.urlPrefix;
            }
        },
        created () {
        },
        methods: {
            save() {
                this.$http.post(`/${this.urlPrefix}/${this.$route.params.model}/store`, this.info)
                    .then(response => {
                    this.buttonLoading = false;
                    this.$message.success('操作成功')
                    this.$router.push({ name: 'admin.model.index', params: {model: this.$route.params.model}})
                }).catch(error => {
                    this.buttonLoading = false;
                    if (typeof error.response.data == 'object') {
                        this.errors = error.response.data;
                    }
                })
            },
        }

    }
</script>