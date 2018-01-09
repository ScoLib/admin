<template>
    <div class="box-header clearfix">
        <div class="btn-group btn-group-sm">
            <router-link
                    :to="{ name: 'admin.model.create', params: {model: $route.params.model}}"
                    v-if="config.accesses.create"
                    class="btn btn-default">
                <i class="fa fa-plus"></i>
                {{ $t('sco.box.create') }} {{ config.title }}
            </router-link>
        </div>
        <div class="btn-group btn-group-sm margin-r-5">
            <button type="button" class="btn btn-primary" @click.prevent="refresh">
                <i class="fa fa-refresh"></i>
                {{ $t('sco.box.refresh') }}
            </button>
        </div>
        <slot></slot>

        <div class="pull-right" v-if="config.display.filters.elements.length > 0">
            <el-dialog :title="$t('sco.box.filter')" :visible.sync="showFilter">

                <div class="box-body form-horizontal">
                    <div class="form-group"
                         v-for="filter in config.display.filters.elements">
                        <label class="col-sm-3 control-label">{{ filter.title }}</label>

                        <v-element
                                class="col-sm-9"
                                :element="filter"
                                v-model="currentValue[filter.name]">
                        </v-element>
                    </div>
                </div>
                <!-- /.box-body -->
                <div slot="footer" class="dialog-footer">
                    <el-button @click="showFilter = false" class="btn btn-default">
                        {{ $t('sco.box.cancel') }}
                    </el-button>
                    <el-button
                        type="primary"
                        @click="doFilter"
                        class="btn btn-info pull-right">
                        {{ $t('sco.box.ok') }}
                    </el-button>
                </div>

            </el-dialog>

            <el-button type="primary" class="btn-sm" @click="filter">
                <i class="fa fa-filter"></i> {{ $t('sco.box.filter') }}
            </el-button>
        </div>
    </div>
</template>

<script>
    import mixins from '../../../../../mixins/get-config.js'
    import vElement from '../../elements/element.vue'

    export default {
        name: 'vHeader',
        data() {
            return {
                showFilter: false,
                currentValue: {},
            }
        },
        components: {
            vElement,
        },
        computed: {},
        mixins: [
            mixins,
        ],
        created() {
            this.currentValue = this.getDefaultValue();
        },
        methods: {
            refresh() {
                Object.keys(this.currentValue).forEach(el => { delete this.currentValue[el] })
                this.$emit('refresh');
            },
            filter() {
                this.showFilter = true;
                if (Object.keys(this.currentValue).length == 0) {
                    this.currentValue = this.getDefaultValue();
                }
            },
            doFilter() {
                this.showFilter = false;
                this.$emit('filter', this.currentValue);
            },
            getDefaultValue() {
                return _.assign({}, this.config.display.filters.values);
            }
        }
    }
</script>

<style scoped>
    .form-horizontal .control-label {
        padding-top: 11px;
    }
</style>
<style>
    .el-dialog__body {
        line-height: 1.3;
    }
</style>
