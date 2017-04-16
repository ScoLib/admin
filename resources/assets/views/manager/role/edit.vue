<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#">
                            创建
                        </a>
                    </li>


                </ul>

                <div class="tab-content">
                    <div class="box">
                        <div class="box-header clearfix">
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary btn-xs btn-white dropdown-toggle">
                                    批量
                                    <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" @click.prevent="batchRemove">
                                            <i class="fa fa-trash-o bigger-120"></i> 删除
                                        </a>
                                    </li>
                                </ul>
                            </div>


                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-success btn-xs" @click.prevent="add">
                                    <i class="fa fa-plus bigger-120"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">

                            <el-table :data="pageData.data"
                                      v-loading="tableLoading"
                                      @selection-change="getSelected">

                                <el-table-column
                                        type="selection"
                                        :selectable="selectable">
                                </el-table-column>

                                <el-table-column label="ID"
                                                 prop="id"
                                                 width="60">
                                </el-table-column>

                                <el-table-column label="名称" prop="name">
                                </el-table-column>

                                <el-table-column label="显示名称" prop="display_name">
                                </el-table-column>

                                <el-table-column label="创建时间" prop="created_at">
                                </el-table-column>

                                <el-table-column
                                        label="操作"
                                        width="120"
                                        align="center"
                                        column-key="index">
                                    <template scope="scope">
                                        <div class="hidden-xs btn-group">
                                            <button class="btn btn-xs btn-info"
                                                    @click.prevent="edit(scope.$index)"
                                                    title="编辑">
                                                <i class="fa fa-pencil bigger-120"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger"
                                                    @click.prevent="remove(scope.row.id)"
                                                    :disabled="scope.row.id == 1"
                                                    title="删除">
                                                <i class="fa fa-trash-o bigger-120"></i>
                                            </button>
                                        </div>
                                    </template>
                                </el-table-column>

                            </el-table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <el-pagination
                                    layout="total, prev, pager, next"
                                    :page-size="pageData.per_page"
                                    @current-change="getResults"
                                    :total="pageData.total">
                            </el-pagination>
                        </div>
                    </div>


                </div>
            </div>
            <el-dialog :title="modalTitle" v-model="editModal">
                <form-dialog :info="info" :errors="errors"></form-dialog>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editModal = false">取 消</el-button>
                    <el-button type="primary" @click="save" :loading="buttonLoading">确 定</el-button>
                </div>
            </el-dialog>



        </div>
    </div>
</template>

<script>


    export default {
        data() {
            return {
            }
        },
        computed: {},
        props: {},
        methods: {},
    }
</script>