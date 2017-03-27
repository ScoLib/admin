<template>
    <ul class="pagination pull-right no-margin" v-if="data.total > data.per_page">
        <li :class="['prev', data.current_page == 1 ? 'disabled' : '']" v-if="data.prev_page_url">
            <a href="#" @click.prevent="selectPage(--data.current_page)">
                <i class="ace-icon fa fa-angle-double-left"></i>
            </a>
        </li>

        <li v-for="n in getPages()" :class="{ 'active': n == data.current_page }">
            <a href="#" @click.prevent="selectPage(n)">{{ n }}</a>
        </li>

        <li :class="['next', data.current_page == 1 ? 'disabled' : '']" v-if="data.next_page_url">
            <a href="#" @click.prevent="selectPage(++data.current_page)">
                <i class="ace-icon fa fa-angle-double-right"></i>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'bPagination',
        props: {
            data: {
                type: Object,
                default() {
                    return {
                        total: 0,
                        per_page: 10,
                        current_page: 1,
                        last_page: 1,
                        from: 1,
                        next_page_url: null,
                        prev_page_url: null,
                        to: 1,
                        data: [],
                    }
                }
            },
            limit: {
                type: Number,
                default: 0
            }
        },
        methods: {
            selectPage(page) {
                this.$emit('pagination-change-page', page);
            },
            getPages() {
                if (this.limit === -1) {
                    return 0;
                }

                if (this.limit === 0) {
                    return this.data.last_page;
                }

                let start = this.data.current_page - this.limit,
                    end = this.data.current_page + this.limit + 1,
                    pages = [],
                    index;

                start = start < 1 ? 1 : start;
                end = end >= this.data.last_page ? this.data.last_page + 1 : end;

                for (index = start; index < end; index++) {
                    pages.push(index);
                }

                return pages;
            }
        }
    };
</script>