<template>
    <div class="box">
        <v-header @refresh="fetchData"></v-header>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="thumbnails clearfix" v-viewer>
                        <!-- #section:pages/gallery -->
                        <li v-for="item in pageData.data">
                            <img width="150" height="150" alt="150x150" :src="item.url">

                            <!--<div class="tags">
                                <span class="label-holder">
                                    <span class="label label-info">breakfast</span>
                                </span>

                                <span class="label-holder">
                                    <span class="label label-danger">fruits</span>
                                </span>

                                <span class="label-holder">
                                    <span class="label label-success">toast</span>
                                </span>

                                <span class="label-holder">
                                    <span class="label label-warning arrowed-in">diet</span>
                                </span>
                            </div>-->

                            <div class="tools tools-bottom">
                                <a href="#">
                                    <i class="fa fa-link"></i>
                                </a>

                                <a href="#">
                                    <i class="fa fa-paperclip"></i>
                                </a>

                                <router-link
                                        :to="{name:'admin.model.edit', params:{model:'pictures'}}"
                                        title="编辑">
                                    <i class="fa fa-pencil bigger-120"></i>
                                </router-link>

                                <a href="#">
                                    <i class="ace-icon fa fa-times red"></i>
                                </a>

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