<template>
    <div>
        <router-link
            :to="value.url"
            v-if="column.type == 'link'">
            {{ value.title }}
        </router-link>

        <el-tag
            v-else-if="column.type == 'tags'"
            type="primary"
            :key="item"
            v-for="item in value">
            {{ item }}
        </el-tag>

        <v-image
            v-else-if="column.type == 'image'"
            :row="row"
            :column="column">
        </v-image>

        <span
            v-else-if="column.type == 'html'"
            v-html="value">
        </span>
        <span v-else>{{ value }}</span>
    </div>
</template>

<script>
    import vImage from './image.vue'

    export default {
        name: "vColumn",
        data() {
            return {}
        },
        components: {
            vImage,
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
