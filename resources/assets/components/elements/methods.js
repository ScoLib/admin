export default {

    methods: {
        handleSuccess(response, file, fileList) {
//                file.id = response.id;
//                this.currentValue.push(file);
            console.log(fileList);
            if (this.element.fileUploadsLimit && this.element.fileUploadsLimit < fileList.length) {
//                    this.$message.error('最多只能上传 ' + this.element.fileUploadsLimit +' 个文件');
                var rfile = fileList.shift();
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
        handleRemove(file, fileList) {
//                console.log(file, fileList);
//                if (file && file.uid) {
//                    delete this.uploadList[file.uid];
//                }
            console.log(fileList);
            this.uploadList = fileList;
            this.currentValue = this.parseFileList(fileList);
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
    }
}