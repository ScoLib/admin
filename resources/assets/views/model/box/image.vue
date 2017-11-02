<template>
    <div class="box">
        <v-header @refresh="fetchData"></v-header>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" v-loading="loading" style="min-height: 70px;">
                <div class="col-xs-12">
                    <ul class="thumbnails clearfix" v-viewer>
                        <!-- #section:pages/gallery -->
                        <li v-for="item in pageData.data">
                            <div>
                                <img width="200" height="200" alt="" :src="item.url">
                                <div class="tools">
                                    <span>好吃的汉堡</span>
                                    <div class="bottom clearfix">
                                        <time class="time">2017-11-02 20:23</time>
                                        <action-column class="pull-right" :row="item"></action-column>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
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
    import vHeader from './header.vue'
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