export default {
    data() {
        return {
            currentValue: [],
        }
    },
    methods: {
        handleError(err, file, fileList) {

//                console.log(err, file, fileList);
        },

        handlePreview(file) {
            console.log(file);
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
            if (this.element.maxFileSize && this.element.maxFileSize <= file.size) {
                var msg = '文件 ' + file.name + ' 太大，不能超过 '
                    + (this.element.maxFileSize / 1024 / 1024).toFixed(2) + ' MB';
                this.$message.error(msg);
                return false;
            }

            var imgType = file.name.substring(file.name.lastIndexOf(".") + 1).toLowerCase();
            if ($.inArray(imgType, this.element.fileExtensions.split(',')) == -1) {
                this.$message.error('文件格式有误');
                return false;
            }
        }
    },
    props: {
        value: {
            type: Array|Object,
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