<template>
    <div class="box-header clearfix">
        <div class="btn-group btn-group-sm">
            <router-link
                    :to="{ name: 'admin.model.create', params: {model: $route.params.model}}"
                    v-if="config.accesses.create"
                    class="btn btn-default">
                <i class="fa fa-plus"></i>
                创建 {{ config.title }}
            </router-link>
        </div>
        <div class="btn-group btn-group-sm margin-r-5">
            <button type="button" class="btn btn-primary" @click.prevent="refresh">
                <i class="fa fa-refresh"></i>
                {{ $t('table.refresh') }}
            </button>
        </div>
        <slot></slot>
        <v-filter
                v-if="config.view.filters.elements.length > 0"
                :filters="config.view.filters.elements"
                v-model="currentValue">
        </v-filter>
    </div>
</template>

<script>
    import mixins from '../../../../mixins/get-config.js'
    import vModel from '../../../../mixins/model.js'
    import vFilter from './filter'

    export default {
        name: 'vHeader',
        data() {
            return {}
        },
        components: {
            vFilter
        },
        mixins: [
            mixins,
            vModel
        ],
        created() {
            this.currentValue = this.config.view.filters.values
        },
        methods: {
            refresh() {
                this.$emit('refresh');
            }
        }
    }
</script>