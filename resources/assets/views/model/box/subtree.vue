<template>
    <ol class="dd-list">
        <li class="dd-item" :data-id="item.id" v-for="item in treeData">
            <div class="dd-handle">
                {{ item.title }}
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
            <!--<subtree v-if="item.children" :tree-data="item.children"></subtree>-->
        </li>
    </ol>
</template>

<script>
    export default {
        name: 'Subtree',
        data() {
            return {}
        },
        props: {
            treeData: {
                type: Object|Array,
                default () {
                    return {};
                }
            }
        },
        created () {
//            console.log(this.treeData);
        },
    }
</script>