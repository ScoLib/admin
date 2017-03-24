<template>
    <div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="thin-border-bottom">
            <tr>
                <th>
                    <i class="ace-icon fa fa-user"></i>
                    User
                </th>

                <th>

                    Email
                </th>
                <th class="hidden-480">Status</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td class="">Alex</td>

                <td>
                    <a href="#">alex@email.com</a>
                </td>

                <td class="hidden-480">
                    <span class="label label-warning">Pending</span>
                </td>
            </tr>

            <tr>
                <td class="">Fred</td>

                <td>
                    <a href="#">fred@email.com</a>
                </td>

                <td class="hidden-480">
                    <span class="label label-success arrowed-in arrowed-in-right">Approved</span>
                </td>
            </tr>

            <tr>
                <td class="">Jack</td>

                <td>
                    <a href="#">jack@email.com</a>
                </td>

                <td class="hidden-480">
                    <span class="label label-warning">Pending</span>
                </td>
            </tr>

            <tr>
                <td class="">John</td>

                <td>
                    <a href="#">john@email.com</a>
                </td>

                <td class="hidden-480">
                    <span class="label label-inverse arrowed">Blocked</span>
                </td>
            </tr>

            <tr>
                <td class="">James</td>

                <td>
                    <a href="#">james@email.com</a>
                </td>

                <td class="hidden-480">
                    <span class="label label-info arrowed-in arrowed-in-right">Online</span>
                </td>
            </tr>
            </tbody>
        </table>
        <pagination :data="pageData" v-on:pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>

    import Pagination from './Pagination.vue';

    export default {
        components: {
            Pagination
        },
        data () {
            return {
                pageData: {},
            }
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }


            }
        },
        props: {

        }
    }
</script>