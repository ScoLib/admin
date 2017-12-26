<template>
    <markdown-editor
            :autoinit="element.autoInit"
            :highlight="element.highlight"
            :configs="element.configs"
            v-model="currentValue"
            ref="markdownEditor">
    </markdown-editor>
</template>

<script>
    import vModel from '../../../../mixins/model'
    import markdownEditor from 'vue-simplemde/src/markdown-editor'

    export default {
        name: "vMarkdown",
        data() {
            return {}
        },
        mixins: [
            vModel
        ],
        components: {
            markdownEditor
        },
        props: {
            element: Object,
        },
    }
</script>

<style>
    @import '~simplemde/dist/simplemde.min.css';
    .markdown-editor .fullscreen {
        z-index: 1031 !important;
    }
    .markdown-editor .CodeMirror-fullscreen {
        z-index: 1031 !important;
    }
</style>