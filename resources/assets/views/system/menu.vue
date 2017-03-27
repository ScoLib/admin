<template>
    <div class="row">
        <div class="col-xs-12">
            <b-table :columns="columns" :data="data"></b-table>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                title: '菜单管理',
                breads: [
                    {
                        'url': '',
                        'title': '系统管理',
                    }
                ],
                columns: [
/*                    {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    },*/
                    {
                        title: 'ID',
                        key: 'id'
                    },
                    {
                        title: '标题',
                        key: 'display_name'
                    },
                    {
                        title: '名称',
                        key: 'name'
                    },
                    {
                        title: '菜单',
                        key: 'is_menu',
                    },
                    {
                        title: '图标',
                        key: 'icon',
                    },
                    {
                        title: '排序',
                        key: 'sort',
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 150,
                        align: 'center',
                        render (row, column, index) {
                            return `<i-button type="primary" size="small" @click="show(${index})">查看</i-button> <i-button type="error" size="small" @click="remove(${index})">删除</i-button>`;
                        }
                    }
                ],
                data: {}
            }
        },
        beforeRouteEnter (to, from, next) {
            next();
        },
        created () {
            this.fetchData();
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.$http.get('/admin/system/menu/list').then(response => {
                    this.data = response.data;
                })

            },
            fetchData () {
                this.$parent.setBreads(this.breads, this.title);
                this.getResults(1);

//                this.$Message.info('这是一个消息', 200);
            },
            show (index) {
                this.$Modal.info({
                    title: '用户信息',
                    content: `姓名：${this.data[index].name}<br>年龄：${this.data[index].age}<br>地址：${this.data[index].address}`
                })
            },
            remove (index) {
                this.data.splice(index, 1);
            }
        }
    }
</script>

