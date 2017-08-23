<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clearfix">
                    <h3 class="box-title">创建 {{ config.title }}</h3>

                    <div class="btn-group btn-group-sm pull-right">
                        <button
                                type="button"
                                class="btn btn-default"
                                @click.prevent="$router.push({ name: 'admin.model.index', params: {model: $route.params.model}})">
                            <i class="fa fa-reply bigger-120"></i>
                            {{ $t('form.back') }}
                        </button>
                    </div>
                    <div class="btn-group btn-group-sm pull-right margin-r-5">

                    </div>
                </div>
                <!-- /.box-header -->
                <v-form
                        :elements="info.elements"
                        v-model="info.values"
                        v-loading="formLoading"
                        :errors="errors">
                </v-form>

                <!-- /.box-body -->
                <div class="box-footer">
                    <el-button
                            type="primary"
                            @click="save"
                            :loading="buttonLoading">
                        {{ $t('form.ok') }}
                    </el-button>

                    <el-button
                            class="btn btn-primary"
                            @click.prevent="refresh">
                        {{ $t('table.reset') }}
                    </el-button>

                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
</template>

<script>
    import vForm from '../../components/form.vue';
    import mixins from './mixins'

    export default {
        mixins: [
            mixins
        ],
        components: {
            vForm
        },
        data() {
            return {
                info: {},
                errors: {},
                formLoading: false,
                buttonLoading: false,
            }
        },
        computed: {

        },
        created () {
            if (Object.keys(this.$store.state.modelCreateInfo).indexOf(this.$route.params.model) == -1) {
                this.getCreateInfo();
            } else {
                let info = $.extend(true, {}, this.$store.state.modelCreateInfo[this.$route.params.model]);
                this.info = info;
            }
        },
        methods: {
            save() {
//                console.log(this.info.values);
//                return false;
                this.buttonLoading = true;
                this.$http.post(
                    `/${this.getUrlPrefix()}/${this.$route.params.model}/store`,
                    this.info.values
                ).then(response => {
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
            getCreateInfo() {
                this.formLoading = true;
                this.info = {};
                this.errors = {};
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/create/info`)
                    .then(response => {
                        this.formLoading = false;
                        this.info = $.extend(true, {}, response.data);
                        this.$store.commit('setModelCreateInfo', {
                            key: this.$route.params.model,
                            value: response.data
                        });
                    }).catch(error => {
                        if (error.response) {
                            this.$message.error(error.response.data)
                        }
                })
            },
            refresh() {
                this.getCreateInfo();
            }
        }
    }
</script>