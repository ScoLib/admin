<template>
    <div>
        <template v-if="type !== 'textarea'">
            <input
                    v-if="type !== 'textarea'"
                    :class="['form-control', customClass]"
                    :type="type"
                    :name="name"
                    :placeholder="placeholder"
                    :disabled="disabled"
                    :readonly="readonly"
                    :maxlength="maxlength"
                    :minlength="minlength"
                    :autocomplete="autoComplete"
                    :autofocus="autofocus"
                    :min="min"
                    :max="max"
                    :step="step"
                    :value="currentValue"
                    ref="input"
                    @input="handleInput"
                    @focus="handleFocus"
                    @blur="handleBlur"
            >
        </template>
        <textarea
                v-else
                :class="['form-control', customClass]"
                :value="currentValue"
                @input="handleInput"
                ref="textarea"
                :name="name"
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :rows="rows"
                :autofocus="autofocus"
                :maxlength="maxlength"
                :minlength="minlength"
                @focus="handleFocus"
                @blur="handleBlur">
    </textarea>
    </div>
</template>
<script>

    export default {
        name: 'bInput',

        data() {
            return {
                currentValue: this.value,
            };
        },

        props: {
            value: [String, Number],
            placeholder: String,
            size: String,
            resize: String,
            readonly: Boolean,
            autofocus: Boolean,
            disabled: Boolean,
            type: {
                type: String,
                default: 'text'
            },
            name: String,
            autosize: {
                type: [Boolean, Object],
                default: false
            },
            rows: {
                type: Number,
                default: 2
            },
            autoComplete: {
                type: String,
                default: 'off'
            },
            maxlength: Number,
            minlength: Number,
            max: {},
            min: {},
            step: {},
            customClass: {
                type: String,
                default: ''
            },
        },

        computed: {
        },

        watch: {
            'value'(val, oldValue) {
                this.setCurrentValue(val);
            }
        },

        methods: {
            handleBlur(event) {
                this.$emit('blur', event);
            },
            inputSelect() {
                this.$refs.input.select();
            },
            handleFocus(event) {
                this.$emit('focus', event);
            },
            handleInput(event) {
                const value = event.target.value;
                this.$emit('input', value);
                this.setCurrentValue(value);
                this.$emit('change', value);
            },
            setCurrentValue(value) {
                if (value === this.currentValue) return;
                this.currentValue = value;
            }
        },

        created() {
            this.$on('inputSelect', this.inputSelect);
        },

        mounted() {
        }
    };
</script>
