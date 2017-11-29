<template>
    <div class="error-page">
        <h2 class="headline text-orange" v-if="$route.name == 'admin.403'"> 403</h2>
        <h2 class="headline text-yellow" v-else-if="$route.name == 'admin.404'"> 404</h2>
        <h2 class="headline text-red" v-else-if="$route.name == 'admin.500'"> 500</h2>

        <div class="error-content">
            <h3>
                <i class="fa fa-warning text-orange" v-if="$route.name == 'admin.403'"></i>
                <i class="fa fa-warning text-yellow" v-else-if="$route.name == 'admin.404'"></i>
                <i class="fa fa-warning text-red" v-else-if="$route.name == 'admin.500'"></i>
                Oops! {{ titles[$route.name] }}.</h3>
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
                titles: {
                    'admin.403': 'Access Denied',
                    'admin.404': 'Page not found',
                    'admin.500': 'Something went wrong',
                },
                messages: {
                    'admin.403': 'You don\'t have permission to access on this page.',
                    'admin.404': 'We could not find the page you were looking for.',
                    'admin.500': 'We will work on fixing that right away. ',
                }
            }
        },
        computed: {
            msg() {
                return this.$store.state.errorMsg ? this.$store.state.errorMsg.message : this.messages[this.$route.name];
            }
        },
    }
</script>