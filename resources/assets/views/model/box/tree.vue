<template>
    <div class="box">
        <v-header></v-header>
        <!-- /.box-header -->
        <!--<v-table></v-table>-->
        <div class="box-body table-responsive">
            <div class="dd">
                <ol class="dd-list">
                    <li class="dd-item" data-id="1">
                        <div class="dd-handle">Item 1</div>
                    </li>
                    <li class="dd-item" data-id="2">
                        <div class="dd-handle">Item 2</div>
                    </li>
                    <li class="dd-item" data-id="3">
                        <div class="dd-handle">Item 3</div>
                        <ol class="dd-list">
                            <li class="dd-item" data-id="4">
                                <div class="dd-handle">Item 4</div>
                            </li>
                            <li class="dd-item" data-id="5" data-foo="bar">
                                <div class="dd-nodrag">Item 5</div>
                            </li>
                        </ol>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
    import vHeader from './header.vue'
    import 'nestable2/dist/jquery.nestable.min.css'

    console.log($.fn)

    export default {
        name: 'vTree',
        data() {
            return {}
        },
        components: {
            vHeader,
        },
        mounted() {
            console.log(window.jQuery.fn);
            console.log($.fn.nestable);
            $('.dd').nestable({ /* config options */ });
        }
    }
</script>