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
        <v-header></v-header>
        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body table-responsive">
            <div class="dd">
                <ol class="dd-list">
                    <li class="dd-item" data-id="1">
                        <div class="dd-handle">
                            Item 1
                            <div class="hidden-xs btn-group pull-right">
                                <el-button
                                        class="btn btn-xs btn-danger margin-l-2"

                                        title="编辑">
                                    <i class="fa fa-pencil bigger-120"></i>
                                </el-button>
                                <el-button
                                        class="btn btn-xs btn-danger margin-l-2"
                                        title="删除">
                                    <i class="fa fa-trash-o bigger-120"></i>
                                </el-button>
                            </div>
                        </div>
                    </li>
                    <li class="dd-item" data-id="2">
                        <div class="dd-handle">Item 2</div>
                    </li>
                    <li class="dd-item" data-id="3">
                        <div class="dd-handle">Item 3</div>
                        <ol class="dd-list">
                            <li class="dd-item" data-id="4">
                                <div class="dd-handle">Item 4</div>
                            </li>
                            <li class="dd-item" data-id="5" data-foo="bar">
                                <div class="dd-nodrag">Item 5</div>
                            </li>
                        </ol>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
    import vHeader from './header.vue'

    export default {
        name: 'vTree',
        data() {
            return {}
        },
        components: {
            vHeader,
        },
        mounted() {
            $('.dd').nestable({ /* config options */ });
        }
    }
</script>