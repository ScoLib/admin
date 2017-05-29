<template>
    <div class="form-horizontal box-body">
        <div :class="['form-group', errors[field.key] ? 'has-error' : '']" v-for="field in fields">
            <label class="col-xs-12 col-sm-3 no-padding-right control-label">{{ field.title }}</label>

            <div class="col-xs-12 col-sm-9">
                <slot :name="field.key" :field="field">
                    <el-select
                            placeholder="请选择"
                            :class="field.class"
                            :popper-class="field.popperClass"
                            :name="field.key"
                            v-model="info[field.key]"
                            v-if="field.type == 'select'">
                        <el-option
                                :value="option.value"
                                :key="option.value"
                                :label="option.label"
                                v-for="option in field.options">
                        </el-option>
                    </el-select>

                    <el-radio-group
                            v-model="info[field.key]"
                            v-else-if="field.type == 'radio'">
                        <el-radio-button
                                v-for="option in field.options"
                                :name="field.key"
                                :key="option.value"
                                :disabled="option.disabled"
                                :label="option.value">
                            {{option.label}}
                        </el-radio-button>
                    </el-radio-group>

                    <div class="checkbox" v-for="option in field.options" v-else-if="field.type == 'checkbox'">
                        <label>
                            <input
                                    type="checkbox"
                                    :name="field.key"
                                    :value="option.value"
                                    :disabled="option.disabled"
                                    v-model="info[field.key]">
                            {{option.label}}
                        </label>
                    </div>

                    <template v-else-if="typeof field.type === 'undefined' || ['text', 'textarea', 'number', 'email', 'password'].indexOf(field.type) > -1">
                        <el-input
                                :custom-class="field.class"
                                :type="field.type"
                                :name="field.key"
                                :placeholder="field.placeholder ? field.placeholder : field.title"
                                :disabled="field.disabled"
                                :readonly="field.readonly"
                                :rows="field.rows"
                                v-model="info[field.key]">
                        </el-input>
                    </template>

                </slot>
                <span class="help-block" v-if="errors[field.key]">
                    <template v-for="e in errors[field.key]"> {{ e }} </template>
                </span>
            </div>
        </div>
    </div>

</template>

<script>

    export default {
        name: 'bForm',
        data() {
            return {
            }
        },
        props: {
            fields: {
                type: Array,
                default () {
                    return [];
                }
            },
            info: {
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
        }
    }
</script>