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

                <v-element
                        class="col-xs-12 col-sm-8"
                        :element="element"
                        v-model="currentValue[element.name]">
                    <span class="help-block" v-if="errors[element.name]">
                        <template v-for="e in errors[element.name]"> {{ e }} </template>
                    </span>
                </v-element>
            </div>

        </template>
    </div>

</template>

<script>
    import vModel from '../../../mixins/model.js'
    import vElement from './elements/element.vue'

    export default {
        name: 'vForm',
        data() {
            return {}
        },
        mixins: [
            vModel
        ],
        components: {
            vElement,
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

        },
    }
</script>
