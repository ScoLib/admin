<template>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ version }}
        </div>
        <strong>Copyright &copy; 2016-2017 <a href="http://www.scophp.com">Sco</a>.</strong> All rights
        reserved.
    </footer>
</template>

<script>
    export default {
        name: 'AppFooter',
        computed: {
            version() {
                return window.Admin.Version;
            }
        }
    }
</script>