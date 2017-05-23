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
                    <a href="#"><i class="fa fa-dashboard" v-if="key == 0"></i>{{ entry.title }}</a>
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
        }
    }
</script>