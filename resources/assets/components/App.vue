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
                            <li>
                                <i class="ace-icon fa fa-home home-icon"></i>
                                <a href="/admin">首页</a>
                            </li>
                            <li v-for="entry in breads">

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
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <router-view></router-view>
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
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
                title: '',
                breads: []
            }
        },
        components: {
            Navbar,
            Sidebar
        },
        methods: {
            setBreads (breads, title) {
                this.title = title;
                this.breads = breads;
                document.title = title + ' - Sco Admin';
            }
        }
    }
</script>