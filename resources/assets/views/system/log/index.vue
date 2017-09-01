<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary" @click.prevent="fetchData">
                            <i class="fa fa-refresh"></i>
                            刷新
                        </button>
                    </div>

                    <div class="pull-right col-sm-6">
                        <div class="col-sm-4 input-group input-group-sm pull-right">
                            <input
                                    type="text"
                                    name="client_id"
                                    class="form-control"
                                    placeholder="IP"
                                    v-model="searchParams.client_id">

                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" @click.prevent="changePage(1)">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-3 input-group input-group-sm pull-right margin-r-5">
                            <input
                                    type="text"
                                    name="user_id"
                                    class="form-control"
                                    placeholder="UserID"
                                    v-model="searchParams.user_id">
                        </div>
                        <div class="col-sm-3 input-group input-group-sm pull-right margin-r-5">
                            <select name="type" class="form-control" v-model="searchParams.type">
                                <option value="">选择类型</option>
                                <option value="created">created</option>
                                <option value="deleted">deleted</option>
                                <option value="restored">restored</option>
                                <option value="saved">saved</option>
                                <option value="updated">updated</option>
                                <option value="creating">creating</option>
                                <option value="deleting">deleting</option>
                                <option value="restoring">restoring</option>
                                <option value="saving">saving</option>
                                <option value="updating">updating</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                    <el-table :data="pageData.data"
                              v-loading="tableLoading">

                        <el-table-column
                                label="ID"
                                prop="id"
                                width="60">
                        </el-table-column>

                        <el-table-column
                                label="用户"
                                width="100">
                            <template scope="scope">
                                {{ scope.row.user == null ? 'guest' : scope.row.user.name }} / {{ scope.row.user_id }}
                            </template>

                        </el-table-column>

                        <el-table-column
                                label="类型"
                                prop="type"
                                width="90">
                        </el-table-column>

                        <el-table-column label="内容" prop="content">
                        </el-table-column>

                        <el-table-column
                                label="IP"
                                prop="client_ip"
                                width="120">
                        </el-table-column>

                        <el-table-column
                                label="客户端信息"
                                prop="client"
                                width="170">
                        </el-table-column>

                        <el-table-column
                                label="创建时间"
                                prop="created_at"
                                width="160">
                        </el-table-column>

                    </el-table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <el-pagination
                            layout="total, prev, pager, next"
                            :page-size="pageData.per_page"
                            @current-change="changePage"
                            :current-page.sync="searchParams.page"
                            :total="pageData.total">
                    </el-pagination>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        components: {
        },
        data() {
            return {
                // 列表
                tableLoading: false,
                pageData: {},
                page: 1,

                searchParams: {
                    page: 1,
                    type: '',
                },
            }
        },
        computed: {
        },
        created () {
            this.fetchData();
        },
        watch: {
        },
        methods: {
            changePage(page) {
                if (!isNaN(page)) {
                    this.searchParams.page = page;
                }
                this.getResults();
            },
            getResults() {
                this.tableLoading = true;
                this.$http.get('/admin/logs/list', {params: this.searchParams})
                    .then(response => {
                        this.tableLoading = false;
                        this.pageData = response.data;
                    }).catch(error => {})
            },
            fetchData() {
                this.getResults();
            },
        }
    }
</script>

