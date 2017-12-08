<style scoped>
    .el-checkbox-group {
        margin: 7px 0px;
    }

    .el-checkbox {
        margin-bottom: 0px;
    }
</style>
<template>
    <div>
        <el-checkbox
                v-if="element.showCheckAll"
                :indeterminate="isIndeterminate"
                v-model="checkAll"
                @change="handleCheckAllChange">
            全选
        </el-checkbox>
        <el-checkbox-group
                :size="element.size"
                @change="handleCheckedChange"
                v-model="currentValue">
            <el-checkbox
                    v-for="option in element.options"
                    :key="option.value"
                    :label="option.value"
                    :disabled="option.disabled">
                {{option.label}}
            </el-checkbox>
        </el-checkbox-group>
    </div>
</template>

<script>
    import vModel from '../../../../mixins/model';

    export default {
        name: "vCheckbox",
        data() {
            return {
                checkAll: false,
                isIndeterminate: false,
            }
        },
        mixins: [
            vModel
        ],
        created() {
            this.handleCheckedChange(this.currentValue);
        },
        props: {
            element: Object,
        },
        methods: {
            handleCheckAllChange(val) {
                this.currentValue = [];
                if (val) {
                    const _this = this;
                    this.element.options.forEach(function (item) {
                        _this.currentValue.push(item.value);
                    })
                }
                this.isIndeterminate = false;
            },
            handleCheckedChange(value) {
                // console.log(value);
                let checkedCount = value.length;
                this.checkAll = checkedCount === this.element.options.length;
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.element.options.length;
            },
        }

    }
</script>