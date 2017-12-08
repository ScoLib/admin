<template>
    <el-tree
            :data="element.nodes"
            show-checkbox
            node-key="id"
            :ref="'tree_' + element.name"
            default-expand-all
            @check-change="setTreeCheckedKeys"
            :default-checked-keys="getTreeCheckedKeys()">
    </el-tree>
</template>

<script>
    import vModel from '../../../../mixins/model'

    export default {
        name: "vTree",
        data() {
            return {}
        },
        mixins:[
            vModel
        ],
        props: {
            element: Object,
        },
        methods: {
            // 设置选中的节点（包括半选中节点）
            setTreeCheckedKeys() {
                let ref = `tree_${this.element.name}`;
                let $refs = this.$refs[ref];

                let keys = $refs.getCheckedKeys();
                let nodesDOM = $refs.$el.querySelectorAll('.el-tree-node');
                let nodesVue = [].map.call(nodesDOM, node => node.__vue__);
                nodesVue.filter(item => item.node.indeterminate === true).forEach(_vue => {
                    keys.push(_vue.node.data.id);
                });
                this.currentValue = keys;
            },
            // 处理需要设置为选中的节点（移除半选中节点，只保留最深层的）
            getTreeCheckedKeys() {
                return this.iterateKeys(this.element.nodes);
            },
            iterateKeys(nodes) {
                let list = [], _this = this;
                nodes.forEach(node => {
                    if (typeof node.children !== 'undefined' && node.children.length > 0) {
                        list = list.concat(_this.iterateKeys(node.children));
                    } else {
                        if (_this.currentValue.indexOf(node.id) > -1) {
                            list.push(node.id);
                        }
                    }
                })
//                console.log(list)
                return list;
            }
        },
    }
</script>

<style scoped>

</style>