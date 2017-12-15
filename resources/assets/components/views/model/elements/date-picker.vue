<template>
    <el-date-picker
            v-model="currentValue"
            :type="element.type"
            :disabled="element.disabled"
            :readonly="element.readonly"
            :editable="element.editable"
            :size="element.size"
            :format="element.pickerFormat"
            :value-format="element.pickerFormat"
            unlink-panels
            placeholder="选择日期时间">
    </el-date-picker>
</template>

<script>
    import vModel from '../../../../mixins/model'

    export default {
        name: "vDatePicker",
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

</style>