import mixins from '../../../../mixins/get-config'

export default {
    data() {
        return {
            filterParams: {},
        }
    },
    mixins: [
        mixins,
    ],
    created() {
        this.fetchData();
    },
    watch: {
        '$route'() {
            this.fetchData();
        }
    },
    computed: {
        isActionColumn() {
            var accesses = this.config.accesses;
            return accesses.edit || accesses.delete || accesses.restore;
        },
    },
    methods: {
        fetchData() {
            this.filterParams = {};
            // console.log('filterparams', this.filterParams);
            this.getResults();
        },
        filter(params) {
            this.filterParams = params;
            this.getResults();
        }
    }
}
