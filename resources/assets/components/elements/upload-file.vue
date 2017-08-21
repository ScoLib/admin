<template>
    <el-upload
            class="upload-file"
            :action="element.action"
            :on-preview="handlePreview"
            :on-remove="handleRemove"
            :before-upload="beforeUpload"
            :show-file-list="element.showFileList"
            :multiple="element.multiple"
            :drag="element.drag"
            :accept="element.accept"
            :with-credentials="element.withCredentials"
            :file-list="currentValue">
        <el-button size="small" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
    </el-upload>
</template>

<script>
    export default {
        name: 'UploadFile',
        data() {
            return {
                currentValue: this.value
            }
        },
        methods: {
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
            beforeUpload(file) {
                console.log(file);
            }
        },
        props: {
            value: {
                type: Array,
                default() {
                    return []
                }
            },
            element: {
                type: Object,
                default() {
                    return {}
                }
            }
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