<template>
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!--<div class="user-panel">
                <div class="pull-left image">
                    <img src="../../img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ user.name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>-->
            <!-- search form -->
            <!--<form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>-->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <transition name="fade">
                <Submenu
                        :childs="menus"
                        :is-top="true"
                        ul-class="sidebar-menu"
                        v-loading="loading">
                </Submenu>
            </transition>
        </section>
        <!-- /.sidebar -->
    </aside>
</template>



<script>

    import Submenu from './submenu.vue';

    export default {
        name: 'AppSidebar',
        data () {
            return {
                menus: {},
                loading: false,
            }
        },
        components: {
            Submenu
        },
        created () {
            this.loading = true;
            this.$http.get(`/${this.getUrlPrefix()}/menu`).then(response => {
                this.loading = false;
                this.menus = response.data;
            }).catch(error => {});

        },
        mounted() {
            $('.sidebar-menu').tree({

            });
        },
        computed: {
            user() {
                return this.$store.state.user;
            }
        },
        methods: {
        }
    }
</script>