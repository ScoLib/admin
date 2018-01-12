<template>
    <el-upload
            :class="'upload-' + element.type"
            ref="upload"
            :action="element.action"
            :name="element.name"
            :headers="{'Accept': '/json'}"
            :on-remove="handleRemove"
            :on-change="handleChange"
            :on-success="handleSuccess"
            :on-error="handleError"
            :before-upload="beforeUpload"
            :before-remove="beforeRemove"
            :show-file-list="element.showFileList"
            :multiple="element.multiSelect"
            :drag="element.drag"
            :accept="element.accept"
            :with-credentials="element.withCredentials"
            :list-type="element.listType"
            :disabled="element.disabled"
            :limit="element.fileUploadsLimit"
            :on-exceed="handleExceed"
            :file-list="uploadList">
        <i class="el-icon-plus" v-if="element.listType === 'picture-card'"></i>
        <el-button size="small" type="primary" v-else>{{ $t('sco.upload.btn') }}</el-button>

        <div slot="tip" class="el-upload__tip">
            {{ $t('sco.upload.allowFileExtensions', {extensions: element.fileExtensions}) }}
            <template v-if="element.maxFileSize">
                {{ $t('sco.upload.maxFileSize', {max: element.maxFileSize}) }}
            </template>
            <template v-if="element.fileUploadsLimit">
                {{ $t('sco.upload.fileLimit', {limit: element.fileUploadsLimit}) }}
            </template>

        </div>
    </el-upload>
</template>

<script>
    import vModel from '../../../../mixins/model.js'

    export default {
        name: 'vFile',
        mixins: [
            vModel,
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
        props: {
            element: {
                type: Object,
                default() {
                    return {}
                }
            }
        },
        watch: {

        },
        methods: {
            handleExceed(files, fileList) {
                this.$message.warning(this.$t('sco.upload.fileLimit', {limit: this.element.fileUploadsLimit}));
            },
            handleSuccess(response, file, fileList) {
                console.log('handleSuccess', file, fileList);
                this.uploadList = fileList;
                this.currentValue = this.parseFileList(fileList);
            },
            handleChange(file, fileList) {
//                this.currentValue = fileList;
                console.log('handleChange', file, fileList);
            },
            beforeRemove(file, fileList) {
                return this.$confirm(this.$t('sco.upload.removeConfirm', {file: file.name}));
            },
            handleRemove(file, fileList) {
                this.currentValue = this.parseFileList(fileList);
                console.log('handleRemove', file, fileList);
            },
            beforeUpload(file) {
                /*if (this.element.fileUploadsLimit && this.element.fileUploadsLimit <= filesLength) {
                    this.$message.error(this.$t('sco.upload.fileLimit', {limit: this.element.fileUploadsLimit}));
                    return false;
                }*/
                // file.size is Byte
                if (this.element.maxFileSize && this.element.maxFileSize * 1024 <= file.size) {
                    this.$message.warning(this.$t('sco.upload.file_size_wrong', {file: file.name}));
                    return false;
                }

                var imgType = file.name.substring(file.name.lastIndexOf(".") + 1).toLowerCase();
                if (_.indexOf(this.element.fileExtensions.split(','), imgType) == -1) {
                    this.$message.warning(this.$t('sco.upload.file_extension_wrong', {file: file.name}));
                    return false;
                }
            },
            handleError(err, file, fileList) {
                var res = JSON.parse(err.message);
                this.$message.error(this.$t('sco.upload.fail', {msg: res.message}));

                console.log(res.message);
            },
            parseFileList(fileList) {
                const values = [];
                fileList.forEach(function (file) {
                    if (file.response) {
                        values.push(file.response);
                    } else {
                        values.push({
                            'name': file.name,
                            'path': file.path,
                            'url': file.url
                        })
                    }
                })

                return values;
            }
        },
    }
</script>
