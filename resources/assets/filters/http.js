export default function (method, url, data, successCallback, errorCallback) {
    // Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
    // Vue.http.credientials = true;

    if (typeof data === 'function') {
        errorCallback = successCallback;
        successCallback = data;
        data = {};
    }

    let options = {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        credientials: true,
        url: url,
        method: method,
        body: data,
    };
    if (method == 'get') {
        options.params = data;
    }

    Vue.http(options)
        .then(response => {
            this.successCallback = successCallback;
            this.successCallback(response);
        }, response => {
            if (typeof errorCallback != 'undefined') {
                this.errorCallback = errorCallback;
                this.errorCallback(response);
            } else {
                // form表单
                if (typeof this.formLoading != 'undefined') {
                    this.formLoading = false;
                }
                if (typeof this.errors != 'undefined' && typeof response.data == 'object') {
                    this.errors = response.data;
                } else {
                    if (response.status == 401) {
                        this.$message.error(response.statusText);
                    } else {
                        this.$message.error(response.data);
                    }

                }
            }
        });
};
