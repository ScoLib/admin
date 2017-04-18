<template>
    <div class="wrapper">
        <app-header></app-header>
        <app-sidebar></app-sidebar>
        <app-content></app-content>
        <app-footer></app-footer>
    </div>
</template>

<script>
//    import Navbar from './layouts/Navbar.vue';
    import AppHeader from './layouts/Header.vue';
    import AppSidebar from './layouts/Sidebar.vue';
    import AppContent from './layouts/Content.vue';
    import AppFooter from './layouts/Footer.vue';

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