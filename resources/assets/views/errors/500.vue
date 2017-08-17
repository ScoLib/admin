<template>
    <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

            <p>
                {{ msg }} <br>
            </p>

        </div>
    </div>
    <!-- /.error-page -->
</template>

<script>
    export default {
        data() {
            return {
                defaultMsg: 'Internal Server Error'
            }
        },
        computed: {
            msg() {
                return this.$store.state.errorMsg ? this.$store.state.errorMsg : this.defaultMsg;
            }
        },
    }
</script>