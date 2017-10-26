<template>
    <div class="box-header clearfix">
        <div class="btn-group btn-group-sm">
            <router-link
                    :to="{ name: 'admin.model.create', params: {model: $route.params.model}}"
                    v-if="config.permissions.create"
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
    </div>
</template>

<script>
    import mixins from '../mixins'

    export default {
        name: 'vHeader',
        data() {
            return {}
        },
        mixins: [
            mixins
        ],
        computed: {

        },
        methods: {
            refresh() {
                this.$emit('refresh');
            }
        }
    }
</script>