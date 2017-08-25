<template>
    <div>
        <el-upload
                class="upload-images"
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
            <el-button size="small" type="primary" v-if="element.listType === 'picture'">点击上传</el-button>
            <i class="el-icon-plus" v-else></i>
            <div slot="tip" class="el-upload__tip">
                只能上传 {{ element.fileExtensions }} 图片
                <template v-if="element.maxFileSize">
                    ，不超过 {{ (element.maxFileSize / 1024 / 1024).toFixed(2) }} MB
                </template>
                <template v-if="element.fileUploadsLimit">
                    ，不超过 {{ element.fileUploadsLimit }} 张图片
                </template>

            </div>

        </el-upload>
        <!--<el-dialog v-model="dialogVisible" top="0" size="full">
            <img :src="dialogImageUrl" alt="">
        </el-dialog>-->
    </div>
</template>

<script>
    import mixins from './mixins'
    import methods from './methods'

    export default {
        name: 'vImages',
        mixins: [
            mixins,
            methods
        ],
        data() {
            return {
                dialogVisible: false,
                dialogImageUrl: '',
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
            handlePreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleSuccess(response, file, fileList) {
//                file.id = response.id;
//                this.currentValue.push(file);
                console.log(fileList);
                if (this.element.fileUploadsLimit && this.element.fileUploadsLimit < fileList.length) {
//                    this.$message.error('最多只能上传 ' + this.element.fileUploadsLimit +' 个文件');
                    var rfile = fileList.shift();
//                    this.$refs.upload.$emit('remove', rfile)
//                    console.log(this.$refs.upload);
//                    console.log(rfile);
//                    this.uploadList = fileList;
//                    this.currentValue = this.parseFileList(fileList);
                }
                this.uploadList = fileList;
                this.currentValue = this.parseFileList(fileList);
            },
            handleChange(file, fileList) {
//                this.currentValue = fileList;
//             console.log('handleChange', file, fileList);
                /*if (this.element.fileUploadsLimit && this.element.fileUploadsLimit < fileList.length) {
//                    this.$message.error('最多只能上传 ' + this.element.fileUploadsLimit +' 个文件');
                    fileList.shift();
                    console.log(fileList);
                    this.uploadList = fileList;
                    this.currentValue = this.parseFileList(fileList);
                }*/
                // console.log('handleChange', file, fileList);
            },

        },
        props: {

        },
        watch: {

        }
    }
</script>