<template>
    <el-select
            placeholder="请选择"
            :class="element.multiple ? 'el-select-multi' : ''"
            :popper-class="element.popperClass"
            :name="element.name"
            :size="element.size"
            :disabled="element.disabled"
            :multiple="element.multiple"
            v-model="currentValue"
            clearable
            filterable>
        <el-option
                :value="option.value"
                :key="option.value"
                :label="option.label"
                v-for="option in element.options">
        </el-option>
    </el-select>
</template>

<script>
    import vModel from '../../../../mixins/model';

    export default {
        name: 'vSelect',
        data() {
            return {}
        },
        mixins: [
            vModel
        ],
        props: {
            element: Object,
        },
    }
</script>

<style scoped>
    .el-select-multi {
        width: 100%;
    }
</style>
