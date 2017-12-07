export default {
    data() {
        return {
            currentValue: this.value,
        }
    },
    props: ['value'],
    watch: {
        value(val) {
            // console.log('value', val);
            this.currentValue = val;
        },
        currentValue(val) {
            // console.log('current', val);
            this.$emit('input', val);
        }
    }
}