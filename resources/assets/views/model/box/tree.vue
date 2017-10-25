<style>
    @import '~nestable2/dist/jquery.nestable.min.css';
    .dd {
        max-width:inherit;
    }
    .dd-handle {
        height: 32px;
        padding: 4px 10px;
    }
</style>
<template>
    <div class="box">
        <v-header @refresh="getResults"></v-header>
        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body table-responsive">
            <div class="dd">
                <subtree :tree-data="tree"></subtree>
            </div>
        </div>
    </div>
</template>

<script>
    import mixins from '../mixins'
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
        mounted() {
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
        },
        watch: {
        },
        methods: {
            getResults() {
                this.loading = true;
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/list`)
                    .then(response => {
                        this.loading = false;
                        this.tree = response.data;
                    }).catch(error => {})
            },
        }
    }
</script>