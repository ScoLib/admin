<template>
    <img
        v-viewer="column.options"
        :width="row[column.name].width"
        :src="row[column.name].image"
        v-if="row[column.name].image">
</template>

<script>
    import Viewer from 'v-viewer';

    Vue.use(Viewer);

    export default {
        name: "vImage",
        data() {
            return {}
        },
        props: {
            row: Object,
            column: Object,
        },
        computed: {
        },
    }
</script>

<style scoped>

</style>
