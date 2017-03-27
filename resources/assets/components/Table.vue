<template>
    <table class="table table-striped table-bordered table-hover">
        <thead class="thin-border-bottom">
        <tr>
            <th v-for="column in columns" :class="column.class">
                <template v-if="column.type == 'selection'">
                    <input type="checkbox">
                </template>
                <template v-else>
                    {{ column.title }}
                </template>
            </th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="row in data">
            <td v-for="column in columns">
                <template v-if="column.type == 'selection'">
                    <input type="checkbox">
                </template>
                <template v-else>
                    <slot :name="column.key" :row="row">{{ row[column.key] }}</slot>
                </template>
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
                type: Object|Array,
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