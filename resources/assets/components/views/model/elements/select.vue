<template>
    <el-select
            placeholder="请选择"
            :class="element.multiple ? 'el-select-multi' : ''"
            :popper-class="element.popperClass"
            :name="element.key"
            :size="element.size"
            :disabled="element.disabled"
            :multiple="element.multiple"
            v-model="currentValue"
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
    export default {
        name: 'vSelect',
        data() {
            return {
                currentValue: this.value,
            }
        },
        props: {
            element:Object,
            value: {
                type: String,
                default: '',
            },
        },
        watch: {
            value(val) {
//                console.log('value', val);
                this.currentValue = val;
            },
            currentValue(val) {
//                console.log('current', val);
                this.$emit('input', val);
            }
        }
    }
</script>