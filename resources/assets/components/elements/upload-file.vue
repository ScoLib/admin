<template>
    <el-upload
            class="upload-file"
            ref="upload"
            :action="element.action"
            :name="element.key"
            :on-preview="handlePreview"
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
        <el-button size="small" type="primary" v-if="element.listType == 'text'">点击上传</el-button>
        <i class="el-icon-plus" v-else></i>
        <div slot="tip" class="el-upload__tip">
            只能上传 {{ element.fileExtensions.join(',') }} 文件
            <template v-if="element.fileSizeLimit">
                ，且不超过 {{ (element.fileSizeLimit/1024).toFixed(2) }} MB
            </template>
        </div>
    </el-upload>
</template>

<script>
    export default {
        name: 'UploadFile',
        data() {
            return {
                currentValue: [],
                uploadList: [],
            }
        },
        created() {
            const _this = this;
            this.value.forEach(function (url) {
                _this.uploadList.push({
                    'name': url.substring(url.lastIndexOf('/') + 1),
                    'url': url,
                });
            })
        },
        methods: {
            handleSuccess(response, file, fileList) {
//                file.id = response.id;
//                this.currentValue.push(file);
                console.log(fileList);
                this.uploadList = fileList;
                this.currentValue = this.parseFileList(fileList);
            },
            handleError(err, file, fileList) {
//                console.log(err, file, fileList);
            },
            handleRemove(file, fileList) {
//                console.log(file, fileList);
                if (file && file.uid) {
//                    delete this.uploadList[file.uid];
                }
                console.log(fileList);
                this.uploadList = fileList;
                this.currentValue = this.parseFileList(fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
//            handleProgress(event, file, fileList) {
//                console.log('handleProgress', event, file, fileList);
//            },
            handleChange(file, fileList) {
//                this.currentValue = fileList;
                /*console.log('handleChange', file, fileList);
                if (this.element.fileUploadsLimit && this.element.fileUploadsLimit < fileList.length) {
                    this.$message.error('最多只能上传 ' + this.element.fileUploadsLimit +' 个文件');
                    this.currentValue = fileList.slice(-this.element.fileUploadsLimit);
                }
                console.log('handleChange', file, fileList);*/
            },
            beforeUpload(file) {
//                var filesLength = Object.keys(this.uploadList).length;
//                if (this.element.multiple) {
//                    console.log($(this.$refs.upload.$refs['upload-inner'].$refs.input));
//                    console.log($('.el-upload__input'), $('.el-upload__input').files);
//                }
//                if (this.element.fileUploadsLimit && this.element.fileUploadsLimit <= filesLength) {
//                    this.$message.error('最多只能上传 ' + this.element.fileUploadsLimit +' 个文件');
//                    return false;
//                }
                // file.size is Byte
                if (this.element.fileSizeLimit && (this.element.fileSizeLimit * 1024) <= file.size) {
                    var msg = '文件 ' + file.name + ' 太大，不能超过 '
                        + (this.element.fileSizeLimit / 1024).toFixed(2) + ' MB';
                    this.$message.error(msg);
                    return false;
                }

                var imgType=file.name.substring(file.name.lastIndexOf(".") + 1).toLowerCase();
                if ($.inArray(imgType, this.element.fileExtensions) == -1) {
                    this.$message.error('文件格式有误');
                    return false;
                }
            },
            parseFileList(fileList) {
                const values = [];
                fileList.forEach(function (file) {
                    values.push(file.response.path);
                })

                return values;
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