var scoHttp = {
    http: function (options, successCallback, errorCallback) {
        // Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
        // Vue.http.credientials = true;

        options = $.extend(options, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            credientials: true,
        });
        console.log('scohttp');
        console.log(this);
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

    }
};

['get', 'delete', 'head', 'jsonp'].forEach(method => {
    console.log(method);
    console.log(this);
    console.log(scoHttp);
    scoHttp[method] = function (url, options, successCallback, errorCallback) {
        if (typeof options == 'function') {
            errorCallback = successCallback;
            successCallback = options;
            options = {};
        }
        options.url = url;
        options.method = method;
        return scoHttp.http(options, successCallback, errorCallback);
    };

});

/*['post', 'put', 'patch'].forEach(method => {

    scoHttp[method] = function (url, body, options) {
        // return this(assign(options || {}, {url, method, body}));
    };

});*/

export default scoHttp
