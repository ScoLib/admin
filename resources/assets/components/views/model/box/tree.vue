<style>
    @import '~nestable2/dist/jquery.nestable.min.css';
    .dd {
        max-width:inherit;
    }
    .dd-handle {
        height: 32px;
        padding: 4px 10px;
    }
    .empty-text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        color: color(#409EFF s(16%) l(44%));
    }
</style>
<template>
    <div class="box">
        <v-header @refresh="getResults"></v-header>
        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12" v-loading="loading">
                    <div class="dd" v-if="tree.length > 0">
                        <subtree :tree-data="tree" @change="getResults"></subtree>
                    </div>
                    <div v-else style="min-height: 50px;">
                        <span class="empty-text">暂无数据</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import mixins from '../../../../mixins/get-config'
    import vHeader from './header.vue'
    import Subtree from './subtree.vue'

    export default {
        name: 'vTree',
        data() {
            return {
                loading: false,
                tree: {},
                seriaData: {}
            }
        },
        components: {
            vHeader,
            Subtree,
        },
        mixins: [
            mixins
        ],
        created () {
            this.getResults();
        },
        watch: {
            '$route'() {
                this.getResults();
            }
        },
        methods: {
            getResults() {
                this.tree = {};
                this.loading = true;
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/list`)
                    .then(response => {
                        this.loading = false;
                        this.tree = response.data;
                        var _this = this;
                        setTimeout(this.nestable, 100)
                    }).catch(error => {})
            },
            nestable() {
                var _this = this;
                $('.dd').nestable({
                    emptyClass: 'not_need_empty',
                    callback: function (l, e) {
                        var data = $(l).nestable('serialize');
                        if (JSON.stringify(_this.seriaData) != JSON.stringify(data)) {
                            _this.seriaData = data;
                            _this.$http.post(
                                `/${_this.getUrlPrefix()}/${_this.$route.params.model}/reorder`,
                                {data: _this.seriaData}
                            ).then(response => {

                            }).catch(error => {})
                        }
                    }
                });
                $('.not_need_empty').remove();
            }
        }
    }
</script>