<template>
    <div>
        <v-select
                v-if="element.type == 'select'"
                :element="element"
                v-model="currentValue">
        </v-select>

        <el-radio-group
                v-else-if="element.type == 'radio'"
                :size="element.size"
                v-model="currentValue">
            <el-radio
                    v-for="option in element.options"
                    :key="option.value"
                    :disabled="option.disabled"
                    :label="option.value">
                {{ option.label }}
            </el-radio>
        </el-radio-group>

        <v-checkbox
                v-else-if="element.type == 'checkbox'"
                :element="element"
                v-model="currentValue">
        </v-checkbox>

        <v-date-picker
                v-else-if="['date', 'datetime', 'daterange', 'datetimerange'].indexOf(element.type) > -1"
                :element="element"
                v-model="currentValue">
        </v-date-picker>

        <el-time-picker
                v-else-if="['time', 'timerange'].indexOf(element.type) > -1"
                v-model="currentValue"
                :type="element.type"
                :is-range="element.isRange"
                :disabled="element.disabled"
                :readonly="element.readonly"
                :editable="element.editable"
                :size="element.size"
                :format="element.pickerFormat"
                :value-format="element.pickerFormat"
                placeholder="选择时间">
        </el-time-picker>

        <el-input-number
                v-else-if="element.type == 'number'"
                v-model="currentValue"
                :disabled="element.disabled"
                :min="element.min"
                :max="element.max">
        </el-input-number>

        <v-file
                v-else-if="element.type == 'file'"
                :element="element"
                v-model="currentValue">
        </v-file>

        <v-image
                v-else-if="element.type == 'image'"
                :element="element"
                v-model="currentValue">
        </v-image>

        <v-images
                v-else-if="element.type == 'images'"
                :element="element"
                v-model="currentValue">
        </v-images>

        <v-switch
                v-else-if="element.type == 'elswitch'"
                :element="element"
                v-model="currentValue">
        </v-switch>

        <v-tree
                v-else-if="element.type == 'tree'"
                :element="element"
                v-model="currentValue">
        </v-tree>

        <el-input
                v-else-if="element.type == 'textarea'"
                :type="element.type"
                :name="element.name"
                :placeholder="element.placeholder ? element.placeholder : element.title"
                :disabled="element.disabled"
                :readonly="element.readonly"
                :rows="element.rows"
                :minlength="element.minLength"
                :maxlength="element.maxLength"
                :autosize="element.autosize"
                v-model="currentValue">
        </el-input>

        <el-input
                v-else-if="['text', 'email', 'password'].indexOf(element.type) > -1"
                :type="element.type"
                :name="element.name"
                :placeholder="element.placeholder ? element.placeholder : element.title"
                :disabled="element.disabled"
                :readonly="element.readonly"
                :minlength="element.minLength"
                :maxlength="element.maxLength"
                :size="element.size"
                v-model="currentValue">
        </el-input>

        <v-tinymce
                v-else-if="element.type == 'tinymce'"
                :id="element.name"
                :size="element.size"
                :baseUrl="element.baseUrl"
                :plugins="element.plugins"
                :options="element.options"
                v-model="currentValue">
        </v-tinymce>
        <mavon-editor
                v-else-if="element.type == 'markdown'"
                v-model="currentValue">
        </mavon-editor>
        <slot></slot>
    </div>
</template>

<script>
    import vModel from '../../../../mixins/model.js'
    import vFile from './file.vue'
    import vImage from './image.vue'
    import vImages from './images.vue'
    import vSelect from './select.vue'
    import vCheckbox from './checkbox.vue'
    import vSwitch from './switch.vue'
    import vTree from './tree.vue'
    import vDatePicker from './date-picker.vue'
    import vTinymce from 'v-tinymce/src/tinymce.vue'
    import { mavonEditor } from 'mavon-editor'

    export default {
        name: "vElement",
        data() {
            return {}
        },
        mixins: [
            vModel
        ],
        components: {
            vFile,
            vImage,
            vImages,
            vSelect,
            vCheckbox,
            vSwitch,
            vTree,
            vDatePicker,
            vTinymce,
            mavonEditor,
        },
        props: {
            element: Object,
        }
    }
</script>

<style scoped>
    @import '~mavon-editor/dist/css/index.css';
</style>