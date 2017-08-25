<style>
    .upload-image .thumbnail {
        width: 100%;
        height: 100%;
    }
    .upload-image .el-upload .el-progress {
        margin: 10px auto;
    }

    .upload-image .el-upload--text {
        background-color: #fbfdff;
        border: 1px dashed #c0ccda;
        border-radius: 6px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        width: 148px;
        height: 148px;
        cursor: pointer;
        line-height: 146px;
        vertical-align: top;
    }
    .upload-image .el-upload--text:hover {
        border-color: #20a0ff;
        color: #20a0ff;
    }
    .upload-image .el-upload--text i {
        font-size: 28px;
        color: #8c939d;
    }
</style>
<template>
    <el-upload
            class="upload-image"
            ref="upload"
            :action="element.action"
            :name="element.key"
            :on-preview="handlePreview"
            :on-success="handleSuccess"
            :on-error="handleError"
            :on-progress="handleProgress"
            :before-upload="beforeUpload"
            :show-file-list="false"
            :drag="element.drag"
            :accept="element.accept"
            :with-credentials="element.withCredentials"
            :disabled="element.disabled">
        <el-progress
                v-if="progressFile.status === 'uploading'"
                type="circle"
                :percentage="parsePercentage(progressFile.percentage)">
        </el-progress>

        <img v-else-if="imageUrl" :src="imageUrl" class="thumbnail">
        <i class="el-icon-plus" v-else></i>
        <div slot="tip" class="el-upload__tip">
            只能上传 {{ element.fileExtensions }} 图片
            <template v-if="element.maxFileSize">
                ，不超过 {{ (element.maxFileSize / 1024 / 1024).toFixed(2) }} MB
            </template>
        </div>
    </el-upload>
</template>

<script>
    import mixins from './mixins'

    export default {
        name: 'vImage',
        mixins: [
            mixins
        ],
        data() {
            return {
                imageUrl: '',
                progressFile: {},
            }
        },
        created() {
            if (this.value.length) {
                this.imageUrl = this.value[0].url;
            }
        },
        methods: {
            parsePercentage(val) {
                return parseInt(val, 10);
            },
            handleSuccess(response, file, fileList) {
//                console.log(fileList);
//                this.loading = false;
                this.currentValue = [response];
                this.imageUrl = response.url;
            },
            handleProgress(event, file, fileList) {
                this.imageUrl = '';

                this.progressFile = file;
//                console.log('handleProgress', event, file, fileList);
            },
        }
    }
</script>