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
                                        <action-column class="pull-right" :row="item"></action-column>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div v-else style="min-height: 50px;">
                        <span class="empty-text">暂无数据</span>
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
        components: {
            vHeader,
            ActionColumn,
        },
        created() {
            this.fetchData();
        },
        watch: {
            '$route'() {
                this.fetchData();
            }
        },
        methods: {
            fetchData() {
                this.getResults();
            },
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.pageData = {};
                this.loading = true;
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/list`, {params: {'page': page}})
                    .then(response => {
                        this.loading = false;
                        this.pageData = response.data;
                    }).catch(error => {
                })
            },
        }
    }
</script>
