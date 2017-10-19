<template>
    <div class="box">
        <v-header></v-header>
        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body table-responsive">

        </div>

    </div>
</template>

<script>
    import vHeader from './header.vue'

    export default {
        name: 'vImage',
        data() {
            return {}
        },
        components: {
            vHeader,
        },
    }
</script>