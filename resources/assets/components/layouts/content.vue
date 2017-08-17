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
                <li v-for="(entry, key) in breads">
                    <router-link :to="{name: 'admin.dashboard'}" v-if="key == 0">
                        <i class="fa fa-dashboard"></i>{{ entry.title }}
                    </router-link>
                    <a href="#" v-else>{{ entry.title }}</a>
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
            breads () {
                let breads = [];
//                console.log(this.$route.matched);
                this.$route.matched.forEach(route => {
                    if (typeof route.parent === 'object' && route.parent.meta.title) {
                        breads.push({path: route.parent.path, title: route.parent.meta.title});
                    }
                });
                return breads;
            }
        }
    }
</script>