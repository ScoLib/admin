<style>
    .el-upload__input {
        display:none!important;
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
                                v-if="element.type == 'select'"
                                placeholder="请选择"
                                :class="element.class"
                                :popper-class="element.popperClass"
                                :name="element.key"
                                :size="element.size"
                                :disabled="element.disabled"
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
                                v-model="currentValue[element.key]">
                            <el-radio
                                    v-for="option in element.options"
                                    :key="option.value"
                                    :disabled="option.disabled"
                                    :label="option.value">
                                {{ option.label }}
                            </el-radio>
                        </el-radio-group>

                        <el-checkbox-group
                                v-else-if="element.type == 'checkbox'"
                                v-model="currentValue[element.key]">
                            <el-checkbox
                                    v-for="option in element.options"
                                    :key="option.value"
                                    :label="option.value"
                                    :disabled="option.disabled">
                                {{option.label}}
                            </el-checkbox>
                        </el-checkbox-group>

                        <el-date-picker
                                v-else-if="['date', 'datetime'].indexOf(element.type) > -1"
                                :value="currentValue[element.key]"
                                :type="element.type"
                                :disabled="element.disabled"
                                :readonly="element.readonly"
                                :size="element.size"
                                :format="element.format"
                                placeholder="选择日期时间"
                                @input="handleDateChange($event, element.key)">
                        </el-date-picker>

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
                                :on-text="element.text[0]"
                                :off-text="element.text[1]"
                                :on-color="element.color[0]"
                                :off-color="element.color[1]"
                                :on-value="element.values[0]"
                                :off-value="element.values[1]"
                                :name="element.key"
                                :disabled="element.disabled"
                                :width="element.width">
                        </el-switch>

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

                        <template v-else-if="typeof element.type === 'undefined' || ['text', 'email', 'password'].indexOf(element.type) > -1">
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
                currentValue: this.value
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
            handleDateChange(date, key) {
                console.log(date, key);
                var options = {hour12: false};
                if (date instanceof Date) {
                    console.log(date.toLocaleString(undefined, options));
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
                console.log(this.currentValue);
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