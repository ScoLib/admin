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
    import AppHeader from './partials/header.vue';
    import AppSidebar from './partials/sidebar.vue';
    import AppContent from './partials/content.vue';
    import AppFooter from './partials/footer.vue';

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