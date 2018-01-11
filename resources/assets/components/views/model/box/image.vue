<style>
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
        <v-header @refresh="fetchData"></v-header>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" v-loading="loading">
                <div class="col-xs-12">
                    <ul class="thumbnails clearfix" v-viewer v-if="pageData.total">
                        <!-- #section:pages/gallery -->
                        <li v-for="item in pageData.data">
                            <div>
                                <img width="200" height="200" alt="" :src="item._url">
                                <div class="tools">
                                    <div class="bottom clearfix">
                                        <action-column
                                            class="pull-right"
                                            :row="item"
                                            @change="getResults"
                                            v-if="isActionColumn">
                                        </action-column>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div v-else style="min-height: 50px;">
                        <span class="empty-text">{{ $t('el.table.emptyText') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div v-if="pageData.total" class="box-footer clearfix">
            <el-pagination
                layout="total, prev, pager, next"
                :page-size="pageData.per_page"
                :current-page="pageData.current_page"
                @current-change="getResults"
                :total="pageData.total">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    import vHeader from './partials/header.vue'
    import Viewer from 'v-viewer';
    import ActionColumn from '../action-column.vue'
    import vBoxCommon from './box.js'

    Vue.use(Viewer);

    export default {
        name: 'vImage',
        data() {
            return {
                loading: false,
                pageData: {
                    type: Object | Array,
                    default() {
                        return [];
                    }
                },
            }
        },
        mixins: [
            vBoxCommon,
        ],
        components: {
            vHeader,
            ActionColumn,
        },
        computed: {

        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.pageData = {};
                this.loading = true;

                var params = _.assign({'page': page}, this.filterParams);
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/list`, {params: params})
                    .then(response => {
                        this.loading = false;
                        this.pageData = response.data;
                    }).catch(error => {
                })
            },
        }
    }
</script>
