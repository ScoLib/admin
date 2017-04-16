<template>
    <div id="app">
        <navbar></navbar>
        <!-- /section:basics/navbar.layout -->
        <div class="main-container ace-save-state" id="main-container">
            <!-- #section:basics/sidebar -->
            <sidebar></sidebar>
            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="main-content-inner">
                    <!-- #section:basics/content.breadcrumbs -->
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <ul class="breadcrumb">
                            <li v-for="(entry, key) in breads">
                                <i class="ace-icon fa fa-home home-icon" v-if="key == 0"></i>

                                <a href="#" v-if="entry.url == ''">{{ entry.title }}</a>
                                <router-link :to="entry.url" v-if="entry.url != ''">{{ entry.title }}</router-link>
                            </li>

                            <li class="active">{{ title }}</li>

                        </ul><!-- /.breadcrumb -->

                        <!-- #section:basics/content.searchbox -->
                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..."
                                           class="nav-search-input"
                                           id="nav-search-input"
                                           autocomplete="off"/>
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- /.nav-search -->

                        <!-- /section:basics/content.searchbox -->
                    </div>

                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">
                        <!-- PAGE CONTENT BEGINS -->
                        <transition name="fade">
                            <router-view></router-view>
                        </transition>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->


            <div class="footer">
                <div class="footer-inner">
                    <!-- #section:basics/footer -->
                    <div class="footer-content">
                <span class="bigger-120">
                    <span class="blue bolder">Sco</span> &copy; 2016-2017
                </span>
                    </div>

                    <!-- /section:basics/footer -->
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
    </div>
</template>

<script>
    import Navbar from './layouts/Navbar.vue';
    import Sidebar from './layouts/Sidebar.vue';

    export default {
        data () {
            return {
            }
        },
        components: {
            Navbar,
            Sidebar,
        },
        computed: {
            title () {
                return this.$route.meta.title;
            },
            breads () {
                let breads = [];
                this.$route.matched.forEach(route => {
                    if (typeof route.parent === 'object') {
                        let parent = route.parent;
                        breads.push({url: parent.path, title: parent.meta.title});

                    }
                });
                return breads;
            }
        },
        methods: {
        }
    }
</script>