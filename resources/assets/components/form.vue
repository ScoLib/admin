<style>
    .el-upload__input {
        display:none!important;
    }
    .el-switch .el-checkbox-group {
        margin: 7px 0px;
    }
    .el-checkbox {
        margin-bottom: 0px;
    }
    .el-select-multi {
        width: 100%;
    }
</style>

<template>
    <div class="form-horizontal box-body">

        <template v-for="element in elements">
            <template v-if="element.type == 'hidden'">
                <el-input
                        :type="element.type"
                        :name="element.key"
                        :disabled="element.disabled"
                        :readonly="element.readonly"
                        v-model="currentValue[element.key]">
                </el-input>
            </template>
            <div :class="['form-group', errors[element.key] ? 'has-error' : '']" v-else>
                <label class="col-xs-12 col-sm-3 no-padding-right control-label">{{ element.title }}</label>

                <div class="col-xs-12 col-sm-8">
                    <slot :name="element.key" :element="element">
                        <el-select
                                v-if="element.type == 'select'"
                                placeholder="请选择"
                                :class="element.multiple ? 'el-select-multi' : ''"
                                :popper-class="element.popperClass"
                                :name="element.key"
                                :size="element.size"
                                :disabled="element.disabled"
                                :multiple="element.multiple"
                                filterable
                                v-model="currentValue[element.key]">
                            <el-option
                                    :value="option.value"
                                    :key="option.value"
                                    :label="option.label"
                                    v-for="option in element.options">
                            </el-option>
                        </el-select>

                        <el-radio-group
                                v-else-if="element.type == 'radio'"
                                :size="element.size"
                                v-model="currentValue[element.key]">
                            <el-radio
                                    v-for="option in element.options"
                                    :key="option.value"
                                    :disabled="option.disabled"
                                    :label="option.value">
                                {{ option.label }}
                            </el-radio>
                        </el-radio-group>

                        <template v-else-if="element.type == 'checkbox'">
                            <el-checkbox
                                    v-if="element.showCheckAll"
                                    :indeterminate="isIndeterminate[element.key]"
                                    v-model="checkAll[element.key]"
                                    @change="handleCheckAllChange($event, element)">
                                全选
                            </el-checkbox>
                            <el-checkbox-group
                                    :size="element.size"
                                    @change="handleCheckedChange($event, element)"
                                    v-model="currentValue[element.key]">
                                <el-checkbox
                                        v-for="option in element.options"
                                        :key="option.value"
                                        :label="option.value"
                                        :disabled="option.disabled">
                                    {{option.label}}
                                </el-checkbox>
                            </el-checkbox-group>
                        </template>

                        <el-date-picker
                            v-else-if="['date', 'datetime', 'daterange', 'datetimerange'].indexOf(element.type) > -1"
                            v-model="currentValue[element.key]"
                            :type="element.type"
                            :disabled="element.disabled"
                            :readonly="element.readonly"
                            :editable="element.editable"
                            :size="element.size"
                            :format="element.pickerFormat"
                            :value-format="element.pickerFormat"
                            placeholder="选择日期时间">
                        </el-date-picker>

                        <el-time-picker
                            v-else-if="['time', 'timerange'].indexOf(element.type) > -1"
                            v-model="currentValue[element.key]"
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
                                v-model="currentValue[element.key]"
                                :disabled="element.disabled"
                                :min="element.min"
                                :max="element.max">
                        </el-input-number>

                        <v-file
                                v-else-if="element.type == 'file'"
                                :element="element"
                                v-model="currentValue[element.key]">
                        </v-file>

                        <v-image
                                v-else-if="element.type == 'image'"
                                :element="element"
                                v-model="currentValue[element.key]">
                        </v-image>

                        <v-images
                                v-else-if="element.type == 'images'"
                                :element="element"
                                v-model="currentValue[element.key]">
                        </v-images>

                        <el-switch
                                v-else-if="element.type == 'elswitch'"
                                v-model="currentValue[element.key]"
                                :active-text="element.text[0]"
                                :inactive-text="element.text[1]"
                                :active-color="element.color[0]"
                                :inactive-color="element.color[1]"
                                :active-value="element.values[0]"
                                :inactive-value="element.values[1]"
                                :name="element.key"
                                :disabled="element.disabled"
                                :width="element.width">
                        </el-switch>

                        <el-tree
                                v-else-if="element.type == 'tree'"
                                :data="element.nodes"
                                show-checkbox
                                node-key="id"
                                :ref="'tree_' + element.key"
                                default-expand-all
                                @check-change="setTreeCheckedKeys(element.key)"
                                :default-checked-keys="getTreeCheckedKeys(element.nodes, currentValue[element.key])">
                        </el-tree>

                        <el-input
                                v-else-if="element.type == 'textarea'"
                                :type="element.type"
                                :name="element.key"
                                :placeholder="element.placeholder ? element.placeholder : element.title"
                                :disabled="element.disabled"
                                :readonly="element.readonly"
                                :rows="element.rows"
                                :minlength="element.minLength"
                                :maxlength="element.maxLength"
                                :autosize="element.autosize"
                                v-model="currentValue[element.key]">
                        </el-input>

                        <template v-else-if="['text', 'email', 'password'].indexOf(element.type) > -1">
                            <el-input
                                    :type="element.type"
                                    :name="element.key"
                                    :placeholder="element.placeholder ? element.placeholder : element.title"
                                    :disabled="element.disabled"
                                    :readonly="element.readonly"
                                    :minlength="element.minLength"
                                    :maxlength="element.maxLength"
                                    :size="element.size"
                                    v-model="currentValue[element.key]">
                            </el-input>
                        </template>

                    </slot>
                    <span class="help-block" v-if="errors[element.key]">
                    <template v-for="e in errors[element.key]"> {{ e }} </template>
                </span>
                </div>
            </div>

        </template>
    </div>

</template>

<script>
    import vFile from './elements/file'
    import vImage from './elements/image'
    import vImages from './elements/images'

    export default {
        name: 'vForm',
        data() {
            return {
                currentValue: this.value,
                checkAll: [],
                isIndeterminate: [],
            }
        },
        components: {
            vFile,
            vImage,
            vImages,
        },
        props: {
            elements: {
                type: Array,
                default () {
                    return [];
                }
            },
            value: {
                type: Object,
                default() {
                    return {}
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
            handleCheckAllChange(event, element) {
                this.currentValue[element.key] = [];
                if (event.target.checked) {
                    const _this = this;
                    element.options.forEach(function (item) {
                        _this.currentValue[element.key].push(item.value);
                    })
                }
                this.isIndeterminate[element.key] = false;
            },
            handleCheckedChange(value, element) {
                let checkedCount = value.length;
                this.checkAll[element.key] = checkedCount === element.options.length;
                this.isIndeterminate[element.key] = checkedCount > 0 && checkedCount < element.options.length;
            },
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
        watch: {
            value(val) {
//                console.log('value', val);
                this.currentValue = val;
            },
            currentValue(val) {
//                console.log('current', val);
                this.$emit('input', val);
            }
        }
    }
</script>
