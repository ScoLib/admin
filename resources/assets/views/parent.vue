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
    import AppHeader from '../components/layouts/Header.vue';
    import AppSidebar from '../components/layouts/Sidebar.vue';
    import AppContent from '../components/layouts/Content.vue';
    import AppFooter from '../components/layouts/Footer.vue';

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