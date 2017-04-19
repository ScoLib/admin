<template>
    <div class="form-horizontal box-body">
        <div :class="['form-group', errors[field.key] ? 'has-error' : '']" v-for="field in fields">
            <label class="col-xs-12 col-sm-3 no-padding-right control-label">{{ field.title }}</label>

            <div class="col-xs-12 col-sm-9">
                <slot :name="field.key" :field="field">
                    <select
                            :class="['form-control', field.class]"
                            :name="field.key"
                            v-model="info[field.key]"
                            v-if="field.type == 'select'">
                        <option
                                :value="option.value"
                                v-for="option in field.options">
                            {{option.label}}
                        </option>
                    </select>

                    <div class="radio" v-for="option in field.options" v-else-if="field.type == 'radio'">
                        <label>
                            <input
                                    type="radio"
                                    :name="field.key"
                                    :value="option.value"
                                    :disabled="option.disabled"
                                    v-model="info[field.key]">
                            {{option.label}}
                        </label>
                    </div>

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
                        <b-input
                                :custom-class="field.class"
                                :type="field.type"
                                :name="field.key"
                                :placeholder="field.placeholder ? field.placeholder : field.title"
                                :disabled="field.disabled"
                                :readonly="field.readonly"
                                :rows="field.rows"
                                v-model="info[field.key]">
                        </b-input>
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