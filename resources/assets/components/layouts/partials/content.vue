<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ title }}
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <router-link :to="{name: 'admin.dashboard'}">
                        <i class="fa fa-dashboard"></i> 首页
                    </router-link>
                </li>

                <li class="active">{{ title }}</li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <router-view
                    keep-alive
                    transition
                    transition-mode="out-in">
            </router-view>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        name: 'AppContent',
        computed: {
            title () {
                return this.$store.state.metaTitle;
            },
        }
    }
</script>