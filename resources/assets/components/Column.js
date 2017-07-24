export default {
    name: 'vColumn',
    render: function(h) {
        const prop = this.prop;
        const scope = this.scope;
        const template = this.template ? this.template : '<span>{{value}}</span>'
        var render = this.renderContent;

        try {
            if (!this.renderContent) {
                Vue.component('column-render', {
                    template: this.template,
                    data() {
                        return {}
                    },
                    props: ['row', 'value']
                });

                render = (h, props) => {
                    return h('column-render', {props});
                }
            }

            return render.call(this._renderProxy, h, { row: scope.row, value: scope.row[prop] });
        } catch (e) {
            console.log(e);
            this.$message.error('column(' + prop +') template is wrong');
        }
    },
    props: {
        renderContent: Function,
        scope: Object,
        prop: String,
        template: String,
    },
}