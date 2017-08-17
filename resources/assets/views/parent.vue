<template>
    <div class="wrapper">
        <vue-progress-bar></vue-progress-bar>
        <app-header></app-header>
        <app-sidebar></app-sidebar>
        <app-content></app-content>
        <app-footer></app-footer>
    </div>

</template>

<script>
    import AppHeader from '../components/layouts/header.vue';
    import AppSidebar from '../components/layouts/sidebar.vue';
    import AppContent from '../components/layouts/content.vue';
    import AppFooter from '../components/layouts/footer.vue';

    export default {
        data () {
            return {
            }
        },
        components: {
            AppHeader,
            AppSidebar,
            AppContent,
            AppFooter,
        },
        computed: {
        },
        methods: {
        }
    }
</script>