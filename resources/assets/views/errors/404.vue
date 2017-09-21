<template>
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>
                {{ msg }}
            </p>
        </div>
        <!-- /.error-content -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                defaultMsg: 'We could not find the page you were looking for.'
            }
        },
        computed: {
            msg() {
                return this.$store.state.errorMsg ? this.$store.state.errorMsg.message : this.defaultMsg;
            }
        },
    }
</script>