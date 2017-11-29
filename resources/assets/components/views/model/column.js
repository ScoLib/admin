export default {
    name: 'vColumn',
    render: function(h) {
        const scope = this.scope;
        // console.log(scope)
        // console.log(this.column)
        const template = this.column.template ? this.column.template : '<span>{{value}}</span>'

        try {
            Vue.component('column-render', {
                template: template,
                data() {
                    return {}
                },
                props: ['row', 'value', 'column']
            });

            var render = (h, props) => {
                return h('column-render', {props});
            }

            return render.call(
                this._renderProxy,
                h,
                {
                    column: this.column,
                    row: scope.row,
                    value: scope.row[this.column.name]
                }
            );
        } catch (e) {
            console.log(e);
            this.$message.error('column(' + this.column.name +') template is wrong');
        }
    },
    props: {
        scope: Object,
        column: Object,
    },
}