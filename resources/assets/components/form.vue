<style>
    .el-upload__input{
        display:none!important;
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

                <div class="col-xs-12 col-sm-9">
                    <slot :name="element.key" :element="element">
                        <el-select
                                placeholder="请选择"
                                :class="element.class"
                                :popper-class="element.popperClass"
                                :name="element.key"
                                :size="element.size"
                                :disabled="element.disabled"
                                filterable
                                v-model="currentValue[element.key]"
                                v-if="element.type == 'select'">
                            <el-option
                                    :value="option.value"
                                    :key="option.value"
                                    :label="option.label"
                                    v-for="option in element.options">
                            </el-option>
                        </el-select>

                        <el-radio-group
                                v-model="currentValue[element.key]"
                                v-else-if="element.type == 'radio'">
                            <el-radio
                                    v-for="option in element.options"
                                    :key="option.value"
                                    :disabled="option.disabled"
                                    :label="option.value">
                                {{ option.label }}
                            </el-radio>
                        </el-radio-group>

                        <el-checkbox-group
                                v-model="currentValue[element.key]"
                                v-else-if="element.type == 'checkbox'">
                            <el-checkbox
                                    v-for="option in element.options"
                                    :key="option.value"
                                    :label="option.value"
                                    :disabled="option.disabled">
                                {{option.label}}
                            </el-checkbox>
                        </el-checkbox-group>

                        <el-date-picker
                                :value="currentValue[element.key]"
                                type="datetime"
                                :disabled="element.disabled"
                                format="yyyy-MM-dd HH:mm:ss"
                                placeholder="选择日期时间"
                                @input="handleDateChange($event, element.key)"
                                v-else-if="element.type == 'date'">
                        </el-date-picker>

                        <el-input-number
                                v-model="currentValue[element.key]"
                                :disabled="element.disabled"
                                :min="element.min"
                                :max="element.max"
                                v-else-if="element.type == 'number'">
                        </el-input-number>

                        <upload-file
                                :element="element"
                                v-model="currentValue[element.key]"
                                v-else-if="element.type == 'file'">
                        </upload-file>

                        <template v-else-if="typeof element.type === 'undefined' || ['text', 'textarea', 'email', 'password'].indexOf(element.type) > -1">
                            <el-input
                                    :type="element.type"
                                    :name="element.key"
                                    :placeholder="element.placeholder ? element.placeholder : element.title"
                                    :disabled="element.disabled"
                                    :readonly="element.readonly"
                                    :rows="element.rows"
                                    :minlength="element.minLength"
                                    :maxlength="element.maxLength"
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
    import UploadFile from './elements/upload-file'

    export default {
        name: 'vForm',
        data() {
            return {
                currentValue: this.value
            }
        },
        components: {
            UploadFile
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
            handleDateChange(date, key) {
                if (date instanceof Date) {
                    this.currentValue[key] = date.toLocaleString();
                }
                if (date instanceof Array) {
                    console.log(date);
                    this.currentValue[key] = [];
                    date.forEach(d => {
                        if (d instanceof Date) {
                            this.currentValue[key].push(d.toLocaleString());
                        }
                    })
                }
            },
            getFile(e) {
                console.log('sssss')
                console.log(e);
            }
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