var vm = new Vue({
    el: '.wrapper',
    data: {
        info: {}
    },
    methods: {
        createMenu: function (event) {
            // layer.load(2);
            axios.get($(event.target).data('url')).then(function (response) {
                console.log(response);
            }).catch(function (error) {
                if (error.response) {
                    // 请求已发出，但服务器响应的状态码不在 2xx 范围内
                    console.log(error.response.statusText);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
            });
            /*$.getJSON($(event.target).data('url'), function (result) {
                layer.closeAll();
                if (result.state) {
                    vm.info = result.data;
                    layer.open({
                        title: '添加菜单',
                        type: 1,
                        shadeClose: true,
                        area: '450px',
                        content: $('#menu-add').html(),
                        btn: ['确定', '取消'],
                        yes: function (index, layero) {
                            console.log(index);
                        }, cancel: function (index) {
                            layer.close(index);
                        }
                    });
                } else {
                    layer.msg(result.message, {'icon': 2, time : 2500, offset : 0});
                }

            });*/
        },
        editMenu: function (event) {
            layer.load(2);
            $.getJSON($(event.target).data('url'), function (result) {
                layer.closeAll();
                if (result.state) {
                    vm.info = result.data;
                    layer.open({
                        title: '修改状态',
                        type: 1,
                        shadeClose: true,
                        area: '450px',
                        content: $('#menu-add').html(),
                        btn: ['确定', '取消'],
                        yes: function (index, layero) {
                            console.log(index);
                        }, cancel: function (index) {
                            layer.close(index);
                        }
                    });
                } else {
                    layer.msg(result.message, {'icon': 2, time : 2500, offset : 0});
                }

            });
        }
    }
});
