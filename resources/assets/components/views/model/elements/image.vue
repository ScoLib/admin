<template>
    <el-upload
        class="upload-image"
        ref="upload"
        :action="element.action"
        :name="element.name"
        :headers="{'Accept': '/json'}"
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
            {{ $t('sco.box.upload.allowFileExtensions', {extensions: element.fileExtensions}) }}
            <template v-if="element.maxFileSize">
                {{ $t('sco.box.upload.maxFileSize', {max: element.maxFileSize}) }}
            </template>
        </div>
    </el-upload>
</template>

<script>
    import vModel from '../../../../mixins/model.js'

    export default {
        name: 'vImage',
        mixins: [
            vModel
        ],
        data() {
            return {
                imageUrl: '',
                progressFile: {},
            }
        },
        created() {
            if (this.value.length !== 0) {
                this.imageUrl = this.value.url;
            }
        },
        props: {
            element: {
                type: Object,
                default() {
                    return {}
                }
            }
        },
        methods: {
            parsePercentage(val) {
                return parseInt(val, 10);
            },
            beforeUpload(file) {
                // file.size is Byte
                if (this.element.maxFileSize && (this.element.maxFileSize * 1024) <= file.size) {
                    var msg = '文件 ' + file.name + ' 太大，不能超过 '
                        + (this.element.maxFileSize / 1024).toFixed(2) + ' MB';
                    this.$message.error(msg);
                    return false;
                }

                var imgType = file.name.substring(file.name.lastIndexOf(".") + 1).toLowerCase();
                if (_.indexOf(this.element.fileExtensions.split(','), imgType) == -1) {
                    this.$message.error(file.name + '文件格式有误');
                    return false;
                }
            },
            handleError(err, file, fileList) {
                var res = JSON.parse(err.message);
                this.$message.error(this.$t('sco.box.upload.fail', {msg: res.message}));

                console.log(res.message);
            },
            handleSuccess(response, file, fileList) {
                console.log('handleSuccess', response);
//                this.loading = false;
                this.currentValue = response;
                this.imageUrl = response.url;
            },
            handleProgress(event, file, fileList) {
                this.imageUrl = '';

                this.progressFile = file;
                console.log('handleProgress', event, file, fileList);
            },
        }
    }
</script>

<style scoped>
    .upload-image >>> .thumbnail {
        width: 100%;
        height: 100%;
    }

    .upload-image >>> .el-upload .el-progress {
        margin: 10px auto;
    }

    .upload-image >>> .el-upload--text {
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

    .upload-image >>> .el-upload--text:hover {
        border-color: #20a0ff;
        color: #20a0ff;
    }

    .upload-image >>> .el-upload--text i {
        font-size: 28px;
        color: #8c939d;
    }
</style>
