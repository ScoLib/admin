<template>
    <div class="form-horizontal">

        <form-group :error="errors.pid" name="pid" title="父级菜单">
            <select class="input-xlarge" name="pid" v-model="info.pid">
                <option value="0">顶级菜单</option>

                <option :value="menu.id" v-for="menu in menuList"><i v-html="menu.spacer"></i>{{menu.display_name}}</option>
            </select>
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.display_name" name="display_name" title="显示名称">
            <input class="col-xs-12 col-sm-9" type="text"
                   id="display_name"
                   name="display_name"
                   v-model="info.display_name">
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.name" name="name" title="菜单标识">
            <input type="text" data-toggle="tooltip"
                   data-original-title="必须是路由的别名，如不是链接，则填“#”"
                   id="name" name="name" class="col-xs-12 col-sm-9 tooltips"
                   placeholder="admin.system.menu"
                   v-model="info.name">
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.icon" name="icon" title="菜单图标">
            <input type="text" id="icon" name="icon" class="col-xs-12 col-sm-9"
                   placeholder="fa-" v-model="info.icon">
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.is_menu" name="is_menu" title="显示菜单">
            <div>
                <label class="line-height-1 blue">
                    <input name="is_menu" value="1" type="radio" class="ace" v-model="info.is_menu">
                    <span class="lbl"> 是</span>
                </label>
            </div>

            <div>
                <label class="line-height-1 blue">
                    <input name="is_menu" value="0" type="radio" class="ace" v-model="info.is_menu">
                    <span class="lbl"> 否</span>
                </label>
            </div>
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.sort" name="sort" title="排序">
            <input type="number" name="sort" data-toggle="tooltip"
                   data-original-title="数字：0~255" class="col-xs-12 col-sm-4 tooltips"
                   v-model="info.sort">
        </form-group>

        <div class="space-2"></div>

        <form-group :error="errors.description" name="description" title="描述">
            <textarea id="description" class="input-xlarge" rows="3" name="description" v-model="info.description"></textarea>
        </form-group>

        <input type="hidden" name="id" v-model="info.id">
    </div>
</template>

<script>

    export default {
        data() {
            return {
//                info: {},
//                menuList: [],
            }
        },
        computed: {
        },
        props: {
            menuList: {
                type: [Object, Array],
                default() {
                    return {}
                }
            },
            info: {
                type: Object,
                default() {
                    return {}
                }
            },
            errors: {
                type: [Object, Array],
                default() {
                    return {}
                }
            }
        },
        methods: {
        },
    }
</script>