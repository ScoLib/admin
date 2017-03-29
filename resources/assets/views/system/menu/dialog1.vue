<template>
    <div class="profile-user-info">

        <div class="profile-info-row">
            <div class="profile-info-name"> 父级菜单 </div>

            <div class="profile-info-value">
                <select class="form-control" name="pid" v-model="info.pid">
                    <option value="0">顶级菜单</option>

                    <option :value="menu.id" v-for="menu in menuList"><i v-html="menu.spacer"></i>{{menu.display_name}}</option>
                </select>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 显示名称 </div>

            <div class="profile-info-value">
                <input class="form-control" type="text" name="title" v-model="info.display_name">
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 名称 </div>

            <div class="profile-info-value">
                <input type="text" data-toggle="tooltip"
                       data-original-title="必须是路由的别名，如不是链接，则填“#”" name="name" class="form-control tooltips" placeholder="admin.system.menu" v-model="info.name">
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 图标 </div>

            <div class="profile-info-value">
                <input type="text" name="icon" class="form-control"
                       placeholder="fa-" v-model="info.icon">
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 菜单 </div>

            <div class="profile-info-value">
                <div class="radio">
                    <label>
                        <input name="is_menu" type="radio" class="ace" value="1" v-model="info.is_menu">
                        <span class="lbl"> 是</span>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input name="is_menu" type="radio" class="ace" value="0" v-model="info.is_menu">
                        <span class="lbl"> 否</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 排序 </div>

            <div class="profile-info-value">
                <input type="text" name="sort" data-toggle="tooltip"
                       data-original-title="数字：0~255" class="form-control tooltips" v-model="info.sort">
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述 </div>

            <div class="profile-info-value">
                <textarea id="description" class="form-control" rows="3" name="description" v-model="info.description"></textarea>
            </div>
        </div>

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
                type: Object,
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
                type: Object,
                default() {
                    return {}
                }
            }
        },
        methods: {
        },
    }
</script>