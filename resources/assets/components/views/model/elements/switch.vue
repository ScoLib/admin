<template>
    <el-switch
            v-model="currentValue"
            :active-icon-class="element.iconClasses[0]"
            :inactive-icon-class="element.iconClasses[1]"
            :active-text="element.texts[0]"
            :inactive-text="element.texts[1]"
            :active-color="element.colors[0]"
            :inactive-color="element.colors[1]"
            :active-value="element.values[0]"
            :inactive-value="element.values[1]"
            :name="element.name"
            :disabled="element.disabled"
            :width="element.width">
    </el-switch>
</template>

<script>
    import vModel from '../../../../mixins/model'

    export default {
        name: "vSwitch",
        data() {
            return {}
        },
        mixins:[
            vModel
        ],
        props: {
            element: Object,
        },
    }
</script>

<style scoped>
    .el-switch {
        line-height: 40px;
        height: 40px;
    }
    .el-switch >>> .el-switch__label {
        height: 40px;
    }
</style>
