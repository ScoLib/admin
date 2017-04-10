<template>
    <div :class="['form-group', error ? 'has-error' : '']">
        <label class="control-label col-xs-12 col-sm-3 no-padding-right" :for="name">{{ title }}</label>

        <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
                <slot></slot>
            </div>
            <div class="help-block" v-show="error">
                <template v-for="e in error"> {{ e }} </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormGroup',
        props: ['name', 'error', 'title']
    }
</script>