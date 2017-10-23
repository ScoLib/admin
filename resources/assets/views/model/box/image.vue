<template>
    <div class="box">
        <v-header @refresh="fetchData"></v-header>

        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body table-responsive">

        </div>

    </div>
</template>

<script>
    import vHeader from './header.vue'

    export default {
        name: 'vImage',
        data() {
            return {
                loading: false,
                pageData: {
                    type: Object|Array,
                    default() {
                        return [];
                    }
                },
            }
        },
        components: {
            vHeader,
        },
        methods: {
            fetchData () {
                this.getResults();
            },
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.pageData = {};
                this.loading = true;
                this.$http.get(`/${this.getUrlPrefix()}/${this.$route.params.model}/list`, {params: {'page': page}})
                    .then(response => {
                        this.loading = false;
                        this.pageData = response.data;
                    }).catch(error => {})
            },
        }
    }
</script>