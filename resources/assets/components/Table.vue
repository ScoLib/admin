<template>
    <table class="table table-striped table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr>
            <th v-for="column in columns">
                {{ column.title }}
            </th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="row in data">
            <td v-for="column in columns">
                {{ row[column.key] }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>

    export default {
        name: 'bTable',
        data () {
            return {

            }
        },
        methods: {

        },
        props: {
            data: {
                type: Object,
                default () {
                    return {};
                }
            },
            columns: {
                type: Array,
                default () {
                    return [];
                }
            }
        }
    }
</script>