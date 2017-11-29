<template>
    <el-upload
            class="upload-file"
            ref="upload"
            :action="element.action"
            :name="element.key"
            :headers="headerInfo"
            :on-remove="handleRemove"
            :on-change="handleChange"
            :on-success="handleSuccess"
            :on-error="handleError"
            :before-upload="beforeUpload"
            :show-file-list="element.showFileList"
            :multiple="element.multiSelect"
            :drag="element.drag"
            :accept="element.accept"
            :with-credentials="element.withCredentials"
            :list-type="element.listType"
            :disabled="element.disabled"
            :file-list="uploadList">
        <el-button size="small" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip">
            只能上传 {{ element.fileExtensions }} 文件
            <template v-if="element.maxFileSize">
                ，不超过 {{ (element.maxFileSize / 1024).toFixed(2) }} MB
            </template>
            <template v-if="element.fileUploadsLimit">
                ，不超过 {{ element.fileUploadsLimit }} 个文件
            </template>

        </div>
    </el-upload>
</template>

<script>
    import mixins from './mixins'
    import methods from './methods'

    export default {
        name: 'vFile',
        mixins: [
            mixins,
            methods
        ],
        data() {
            return {
                uploadList: [],
            }
        },
        created() {
            const _this = this;
            this.value.forEach(function (file) {
                _this.uploadList.push(file);
            })
        },
        methods: {

        },
        props: {

        },
        watch: {

        }
    }
</script>