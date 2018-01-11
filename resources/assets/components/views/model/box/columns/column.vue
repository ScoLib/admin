<template>
    <div>
        <router-link
            :to="value.url"
            v-if="column.type == 'link'">
            {{ value.title }}
        </router-link>

        <p v-else-if="column.type == 'tags'">
            <el-tag type="primary" :key="item" v-for="item in value">{{ item }}</el-tag>
        </p>


        <template v-else-if="column.type == 'image'">
            <img
                v-viewer="column.options"
                :width="value.width"
                :src="value.image"
                v-if="value.image">
        </template>

        <span v-html="value" v-else-if="column.type == 'html'"></span>
        <span v-else>{{ value }}</span>
    </div>
</template>

<script>
    import Viewer from 'v-viewer';

    Vue.use(Viewer);

    export default {
        name: "vColumn",
        data() {
            return {}
        },
        props: {
            row: Object,
            column: Object,
        },
        computed: {
            value() {
                // console.log(this.row[this.column.name]);
                return this.row[this.column.name];
            }
        }
    }
</script>

<style scoped>

</style>
