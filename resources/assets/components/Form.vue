<template>
    <div class="form-horizontal box-body">
        
        <div :class="['form-group', errors[field.key] ? 'has-error' : '']" v-for="field in fields">
            <label class="col-xs-12 col-sm-3 no-padding-right control-label">{{ field.title }}</label>

            <div class="col-xs-12 col-sm-9">
                <slot :name="field.key" :field="field">
                    <Select
                            placeholder="请选择"
                            :class="field.class"
                            :popper-class="field.popperClass"
                            :name="field.key"
                            v-model="info[field.key]"
                            v-if="field.type == 'select'">
                        <Option
                                :value="option.value"
                                :key="option.value"
                                :label="option.label"
                                v-for="option in field.options">
                        </Option>
                    </Select>

                    <Radio-group
                            v-model="info[field.key]"
                            v-else-if="field.type == 'radio'">
                        <Radio
                                v-for="option in field.options"
                                :key="option.value"
                                :disabled="option.disabled"
                                :label="option.label">
                        </Radio>
                    </Radio-group>

                    <Checkbox-group
                            @on-change="testcheckbox"
                            v-model="info[field.key]"
                            v-else-if="field.type == 'checkbox'">
                        <Checkbox
                                :label="option.label"
                                :key="option.value"
                                v-for="option in field.options">
                            {{option.label}}
                        </Checkbox>
                    </Checkbox-group>

                    <!--<div class="checkbox" v-for="option in field.options" v-else-if="field.type == 'checkbox'">
                        <label>
                            <input
                                    type="checkbox"
                                    :name="field.key"
                                    :value="option.value"
                                    :disabled="option.disabled"
                                    v-model="info[field.key]">
                            {{option.label}}
                        </label>
                    </div>-->

                    <template v-else-if="typeof field.type === 'undefined' || ['text', 'textarea', 'number', 'email', 'password'].indexOf(field.type) > -1">
                        <Input
                                :type="field.type"
                                :name="field.key"
                                :placeholder="field.placeholder ? field.placeholder : field.title"
                                :disabled="field.disabled"
                                :readonly="field.readonly"
                                :rows="field.rows"
                                v-model="info[field.key]">
                        </Input>
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
                fruit: [],
            }
        },
        created() {
            console.log(this.info);
            console.log(this.fields);
            this.fields.forEach(f => {
                console.log(this.info[f.key]);
            })
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
        },
        methods: {
            testcheckbox(data) {
                console.log(data);
            }
        }
    }
</script>