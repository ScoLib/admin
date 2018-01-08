<style>
    /**
     * Nestable Draggable Handles
     */
    .dd3-content {
        display: block;
        height: 32px;
        margin: 5px 0;
        padding: 5px 10px 5px 40px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd3-content:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd3-item > button {
        margin-left: 30px;
        font-size: 16px;
    }

    .dd3-handle {
        position: absolute;
        margin: 0;
        left: 0;
        top: 0;
        cursor: pointer;
        width: 30px;
        text-indent: 30px;
        white-space: nowrap;
        overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .dd3-handle:before {
        content: '≡';
        display: block;
        position: absolute;
        left: 0;
        top: 3px;
        width: 100%;
        text-align: center;
        text-indent: 0;
        color: #000;
        font-size: 16px;
        font-weight: normal;
    }

    .dd3-handle:hover {
        background: #ddd;
    }
</style>
<template>
    <ol class="dd-list" v-if="treeData.length > 0">
        <li class="dd-item dd3-item" :data-id="item.id" v-for="item in treeData">
            <div class="dd-handle dd3-handle">Drag</div>
            <div class="dd3-content">
                {{ item.title }}
                <action-column
                        class="pull-right"
                        :row="item"
                        @change="change">
                </action-column>
            </div>
            <subtree v-if="item.children" :tree-data="item.children"></subtree>
        </li>
    </ol>
</template>

<script>
    import ActionColumn from '../../action-column.vue'

    export default {
        name: 'Subtree',
        data() {
            return {}
        },
        components: {
            ActionColumn,
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
        methods: {
            change() {
                this.$emit('change');
            }
        }
    }
</script>
