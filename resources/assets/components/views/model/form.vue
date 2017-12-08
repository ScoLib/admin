<style>
    .el-upload__input {
        display: none !important;
    }

    .el-switch {
        margin: 7px 0px;
    }

</style>

<template>
    <div class="form-horizontal box-body">

        <template v-for="element in elements">
            <template v-if="element.type == 'hidden'">
                <el-input
                        :type="element.type"
                        :name="element.name"
                        :disabled="element.disabled"
                        :readonly="element.readonly"
                        v-model="currentValue[element.name]">
                </el-input>
            </template>
            <div :class="['form-group', errors[element.name] ? 'has-error' : '']" v-else>
                <label class="col-xs-12 col-sm-3 no-padding-right control-label">{{
                    element.title }}</label>

                <div class="col-xs-12 col-sm-8">
                    <slot :name="element.name" :element="element">
                        <v-select
                                v-if="element.type == 'select'"
                                :element="element"
                                v-model="currentValue[element.name]">
                        </v-select>

                        <el-radio-group
                                v-else-if="element.type == 'radio'"
                                :size="element.size"
                                v-model="currentValue[element.name]">
                            <el-radio
                                    v-for="option in element.options"
                                    :key="option.value"
                                    :disabled="option.disabled"
                                    :label="option.value">
                                {{ option.label }}
                            </el-radio>
                        </el-radio-group>

                        <v-checkbox
                                v-else-if="element.type == 'checkbox'"
                                :element="element"
                                v-model="currentValue[element.name]">
                        </v-checkbox>

                        <el-date-picker
                                v-else-if="['date', 'datetime', 'daterange', 'datetimerange'].indexOf(element.type) > -1"
                                v-model="currentValue[element.name]"
                                :type="element.type"
                                :disabled="element.disabled"
                                :readonly="element.readonly"
                                :editable="element.editable"
                                :size="element.size"
                                :format="element.pickerFormat"
                                :value-format="element.pickerFormat"
                                unlink-panels
                                placeholder="选择日期时间">
                        </el-date-picker>

                        <el-time-picker
                                v-else-if="['time', 'timerange'].indexOf(element.type) > -1"
                                v-model="currentValue[element.name]"
                                :type="element.type"
                                :is-range="element.isRange"
                                :disabled="element.disabled"
                                :readonly="element.readonly"
                                :editable="element.editable"
                                :size="element.size"
                                :format="element.pickerFormat"
                                :value-format="element.pickerFormat"
                                placeholder="选择时间">
                        </el-time-picker>

                        <el-input-number
                                v-else-if="element.type == 'number'"
                                v-model="currentValue[element.name]"
                                :disabled="element.disabled"
                                :min="element.min"
                                :max="element.max">
                        </el-input-number>

                        <v-file
                                v-else-if="element.type == 'file'"
                                :element="element"
                                v-model="currentValue[element.name]">
                        </v-file>

                        <v-image
                                v-else-if="element.type == 'image'"
                                :element="element"
                                v-model="currentValue[element.name]">
                        </v-image>

                        <v-images
                                v-else-if="element.type == 'images'"
                                :element="element"
                                v-model="currentValue[element.name]">
                        </v-images>

                        <el-switch
                                v-else-if="element.type == 'elswitch'"
                                v-model="currentValue[element.name]"
                                :active-icon-class="element.iconClasses[0]"
                                :inactive-icon-class="element.iconClasses[1]"
                                :active-text="element.texts[0]"
                                :inactive-text="element.texts[1]"
                                :active-color="element.colors[0]"
                                :inactive-color="element.colors[1]"
                                :active-value="element.values[0]"
                                :inactive-value="element.values[1]"
                                :name="element.name"
                                :disabled="element.disabled"
                                :width="element.width">
                        </el-switch>

                        <el-tree
                                v-else-if="element.type == 'tree'"
                                :data="element.nodes"
                                show-checkbox
                                node-key="id"
                                :ref="'tree_' + element.name"
                                default-expand-all
                                @check-change="setTreeCheckedKeys(element.name)"
                                :default-checked-keys="getTreeCheckedKeys(element.nodes, currentValue[element.name])">
                        </el-tree>

                        <el-input
                                v-else-if="element.type == 'textarea'"
                                :type="element.type"
                                :name="element.name"
                                :placeholder="element.placeholder ? element.placeholder : element.title"
                                :disabled="element.disabled"
                                :readonly="element.readonly"
                                :rows="element.rows"
                                :minlength="element.minLength"
                                :maxlength="element.maxLength"
                                :autosize="element.autosize"
                                v-model="currentValue[element.name]">
                        </el-input>

                        <el-input
                                v-else-if="['text', 'email', 'password'].indexOf(element.type) > -1"
                                :type="element.type"
                                :name="element.name"
                                :placeholder="element.placeholder ? element.placeholder : element.title"
                                :disabled="element.disabled"
                                :readonly="element.readonly"
                                :minlength="element.minLength"
                                :maxlength="element.maxLength"
                                :size="element.size"
                                v-model="currentValue[element.name]">
                        </el-input>

                    </slot>
                    <span class="help-block" v-if="errors[element.name]">
                    <template v-for="e in errors[element.name]"> {{ e }} </template>
                </span>
                </div>
            </div>

        </template>
    </div>

</template>

<script>
    import vModel from '../../../mixins/model'
    import vFile from './elements/file.vue'
    import vImage from './elements/image.vue'
    import vImages from './elements/images.vue'
    import vSelect from './elements/select.vue'
    import vCheckbox from './elements/checkbox.vue'

    export default {
        name: 'vForm',
        data() {
            return {}
        },
        mixins: [
            vModel
        ],
        components: {
            vFile,
            vImage,
            vImages,
            vSelect,
            vCheckbox,
        },
        props: {
            elements: {
                type: Array,
                default() {
                    return [];
                }
            },
            errors: {
                type: [Object, Array],
                default() {
                    return {}
                }
            }
        },
        methods: {
            // 设置选中的节点（包括半选中节点）
            setTreeCheckedKeys(key) {
                let ref = `tree_${key}`;
                let $refs = this.$refs[ref][0];
                let keys = $refs.getCheckedKeys();

                let nodesDOM = $refs.$el.querySelectorAll('.el-tree-node');
                let nodesVue = [].map.call(nodesDOM, node => node.__vue__);
                nodesVue.filter(item => item.node.indeterminate === true).forEach(_vue => {
                    keys.push(_vue.node.data.id);
                });
                this.currentValue[key] = keys;
            },
            // 处理需要设置为选中的节点（移除半选中节点，只保留最深层的）
            getTreeCheckedKeys(nodes, checkedKeys) {
                let list = [];
                nodes.forEach(node => {
                    if (typeof node.children !== 'undefined' && node.children.length > 0) {
                        list = list.concat(this.getTreeCheckedKeys(node.children, checkedKeys));
                    } else {
                        if (checkedKeys.indexOf(node.id) > -1) {
                            list.push(node.id);
                        }
                    }
                })
//                console.log(list)
                return list;
            },
        },
    }
</script>
