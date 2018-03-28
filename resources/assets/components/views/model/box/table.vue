<style>
    .el-table table, .el-table__empty-block {
        width: 100% !important;
    }
    .el-table__body, .el-table__footer, .el-table__header {
        table-layout: initial;
    }
</style>
<template>
    <div class="box">
        <v-header
            @refresh="fetchData"
            @filter="filter">
        </v-header>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <el-table :data="tableData"
                      v-loading="loading">

                <el-table-column
                    :label="column.label"
                    :prop="column.name"
                    :min-width="column.minWidth"
                    :width="column.width"
                    :sortable="column.sortable"
                    :fixed="column.fixed"
                    v-for="column in config.display.columns"
                    :key="column.name">
                    <template slot-scope="scope">
                        <v-column
                            :row="scope.row"
                            :column="column">
                        </v-column>
                    </template>
                </el-table-column>

                <el-table-column
                    :label="$t('sco.box.action')"
                    align="center"
                    width="120"
                    column-key="action"
                    v-if="isActionColumn">
                    <template slot-scope="scope">
                        <action-column
                            :row="scope.row"
                            @change="getResults">
                        </action-column>
                    </template>
                </el-table-column>


            </el-table>
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
    import vColumn from './columns/column.vue'
    import ActionColumn from '../action-column.vue'
    import vBoxCommon from './box.js'
    import vHeader from './partials/header.vue'

    export default {
        name: 'vTable',
        data() {
            return {
                // 列表
                loading: false,
                pageData: {
                    type: Object | Array,
                    default() {
                        return [];
                    }
                },

                selection: [],
                page: 1,
            }
        },
        mixins: [
            vBoxCommon,
        ],
        components: {
            vColumn,
            ActionColumn,
            vHeader,
        },
        computed: {
            tableData() {
                if (Object.keys(this.pageData).length == 0) {
                    return [];
                }
                if (Object.keys(this.pageData).indexOf('data') > -1) {
                    return this.pageData.data;
                }
                return this.pageData;
            },
        },
        methods: {
            getResults(page) {
                this.page = typeof page === 'undefined' ? 1 : page;

                this.pageData = {};
                this.loading = true;

                var params = _.assign({'page': this.page}, this.filterParams);
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
