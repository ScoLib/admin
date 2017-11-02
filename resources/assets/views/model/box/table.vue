<template>
    <div class="box">
        <v-header @refresh="fetchData"></v-header>
        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body table-responsive">
            <el-table :data="tableData"
                      v-loading="loading"
                      @selection-change="getSelected">

                <!--<el-table-column
                        type="selection"
                        :selectable="selectable">
                </el-table-column>-->

                <el-table-column
                        :label="column.label"
                        :prop="column.name"
                        :min-width="column.minWidth"
                        :width="column.width"
                        :sortable="column.sortable"
                        :fixed="column.fixed"
                        v-for="column in config.view.columns"
                        :key="column.name">
                    <template slot-scope="scope">
                        <v-column
                                :scope="scope"
                                :column="column">
                        </v-column>
                    </template>
                </el-table-column>

                <el-table-column
                        label="操作"
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
    import vColumn from '../../../components/column.js'
    import ActionColumn from '../action-column.vue'
    import mixins from '../mixins'
    import Viewer from 'v-viewer';
    import vHeader from './header.vue'
    Vue.use(Viewer);

    export default {
        name: 'vTable',
        data() {
            return {
                // 列表
                loading: false,
                pageData: {
                    type: Object|Array,
                    default() {
                        return [];
                    }
                },

                selection: [],
            }
        },
        mixins: [
            mixins
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

            isActionColumn() {
                var permissions = this.config.permissions;
                return permissions.edit || permissions.delete || permissions.restore;
            },
        },
        created () {
            this.fetchData();
        },
        watch: {
            '$route'() {
                this.fetchData();
            }
        },
        methods: {
            fetchData () {
                this.getResults();
            },
            selectable(row, index) {
                return true;
//                return row.name == 'admin' ? false : true;
            },
            getSelected(selection) {
                this.selection = [];
                selection.forEach(row => {
                    this.selection.push(row[this.config.primaryKey]);
                });
//                console.log(this.selection);
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
                    }).catch(error => {})
            },
        }
    }
</script>