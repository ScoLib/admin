<template>
    <div class="form-horizontal box-body">
        <div :class="['form-group', errors[field.name] ? 'has-error' : '']" v-for="field in fields">
            <label for="inputEmail3" class="col-sm-2 control-label">{{ field.title }}</label>

            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                <span class="help-block" v-if="errors[field.name]">
                    <template v-for="e in errors[field.name]"> {{ e }} </template>
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