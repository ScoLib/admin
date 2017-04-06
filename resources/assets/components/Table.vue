<template>
    <table class="table table-hover">
        <thead>
        <tr>
            <th v-for="column in columns" :class="column.class">
                <template v-if="column.type == 'selection'">
                    <Checkbox :value="checkAll" @on-change="selectAll"></Checkbox>
                </template>
                <template v-else>
                    {{ column.title }}
                </template>
            </th>
        </tr>
        </thead>
        <transition-group name="fade" tag="tbody">
            <tr v-for="(row, key) in data" :key="key">
                <td v-for="column in columns">
                    <template v-if="column.type == 'selection'">
                        <Checkbox :label="row[column.key]" @on-change="toggleSelect"></Checkbox>
                    </template>
                    <template v-else>
                        <slot :name="column.key" :row="row">{{ row[column.key] }}</slot>
                    </template>
                </td>
            </tr>
        </transition-group>
    </table>
</template>

<script>

    export default {
        name: 'bTable',
        data () {
            return {
                checkboxData: {},
                checkAll: false,
            }
        },
        watch: {
            data: {
                handler () {
                    this.checkboxData = this.makeCheckboxData();
                },
                deep: true
            }
        },
        methods: {
            toggleSelect (status) {
                console.log(status);
            },
            selectAll (status) {
                for (const row of this.data) {
                    console.log(row);
                }
            },
            makeCheckboxData () {
                let data = {};
                this.data.forEach((row, index) => {
                    const newRow = row;
                    if (newRow._disabled) {
                        newRow._isDisabled = newRow._disabled;
                    } else {
                        newRow._isDisabled = false;
                    }
                    if (newRow._checked) {
                        newRow._isChecked = newRow._checked;
                    } else {
                        newRow._isChecked = false;
                    }
                    data[index] = newRow;
                });

                return data;
            }
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