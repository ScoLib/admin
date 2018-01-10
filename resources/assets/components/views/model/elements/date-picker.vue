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
            :start-placeholder="$t('sco.box.startDate')"
            :end-placeholder="$t('sco.box.endDate')"
            :placeholder="$t('sco.box.selectDate')">
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
