<template>
    <div class="form-horizontal">

        <form-group :error="errors.name" name="name" title="名称">
            <input type="text" id="name" name="name"
                   class="col-xs-12 col-sm-9"
                   v-model="info.name">
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.email" name="email" title="Email">
            <input type="email" id="email" name="email"
                   class="col-xs-12 col-sm-9"
                   v-model="info.email">
        </form-group>

        <div class="space-2"></div>


        <form-group :error="errors.password" name="password" title="密码">
            <input type="password" id="password" name="password"
                   class="col-xs-12 col-sm-9"
                   v-model="info.password">
        </form-group>

        <input type="hidden" name="id" v-model="info.id">
    </div>
</template>

<script>

    const FormGroup = {
        template: `<div :class="['form-group', error ? 'has-error' : '']">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" :for="name">{{ title }}</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <slot></slot>
                </div>
                <div class="help-block" v-show="error">
                    <template v-for="e in error"> {{ e }} </template>
                </div>
            </div>
        </div>`,
        props: ['name', 'error', 'title']
    }

    export default {
        components: {
            FormGroup
        },
        data() {
            return {
//                info: {},
//                menuList: [],
            }
        },
        computed: {},
        props: {
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
        methods: {},
    }
</script>