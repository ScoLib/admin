<template>
    <div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed display">

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>

                <!-- #section:basics/sidebar.layout.shortcuts -->
                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>

                <!-- /section:basics/sidebar.layout.shortcuts -->
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>

                <span class="btn btn-info"></span>

                <span class="btn btn-warning"></span>

                <span class="btn btn-danger"></span>
            </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
            <template v-for="menu in menus">
                <li v-if="menu.name == '#'">
                    <a href="#" :class="{ 'dropdown-toggle' : Object.keys(menu.child).length > 0 }">
                        <i :class="['menu-icon', 'fa', menu.icon ? menu.icon : '']"></i>
                        <span class="menu-text"> {{ menu.display_name }} </span>

                        <b v-if="Object.keys(menu.child).length > 0" class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <Submenu v-if="Object.keys(menu.child).length > 0" :childs="menu.child"></Submenu>

                </li>

                <router-link tag="li"
                             v-if="menu.name != '#'"
                             :to="{ name: menu.name}"
                             :active-class="Object.keys(menu.child).length > 0 ? 'active open' : 'active'"
                             exact
                >
                    <a :class="{ 'dropdown-toggle' : Object.keys(menu.child).length > 0 }">
                        <i :class="['menu-icon', 'fa', menu.icon ? menu.icon : '']"></i>
                        <span class="menu-text"> {{ menu.display_name }} </span>

                        <b v-if="Object.keys(menu.child).length > 0" class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <Submenu v-if="Object.keys(menu.child).length > 0" :childs="menu.child"></Submenu>
                </router-link>
            </template>
        </ul><!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
               data-icon1="ace-icon fa fa-angle-double-left"
               data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
    </div>
</template>



<script>

    import Submenu from './Submenu.vue';

    export default {
        data () {
            return {
                menus: {}
            }
        },
        components: {
            Submenu
        },
        created () {
//            this.$Message.loading('正在加载中...', 0);
            this.$http.get('/admin/menu').then(response => {
                this.menus = response.data;
//                this.$Message.destroy();
            });
        }
    }
</script>