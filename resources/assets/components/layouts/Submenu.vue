<template>
    <ul :class="ulClass">
        <li class="header" v-if="isTop">MAIN NAVIGATION</li>

        <router-link
                tag="li"
                v-for="child in childs"
                :to="child.name == '#' ? notUrl : child.url"
                :class="activeClass(child.child)"
                :key="child.id"
                exact>
            <a>
                <i :class="['fa', child.icon ? child.icon : 'fa-circle-o']"></i>
                <span v-if="isTop"> {{ child.display_name }} </span>
                <template v-else>{{ child.display_name }}</template>

                <span class="pull-right-container" v-if="Object.keys(child.child).length > 0">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <Submenu v-if="Object.keys(child.child).length > 0" :childs="child.child"></Submenu>
        </router-link>
    </ul>

</template>

<script>

    export default {
        name: 'Submenu',
        props: {
            childs: {
                type: Object,
                default () {
                    return {};
                }
            },
            isTop: {
                type: Boolean,
                default: false,
            },
            ulClass: {
                type: String,
                default () {
                    return 'treeview-menu';
                }
            }
        },
        computed: {
            notUrl () {
                return '/#';
            }
        },
        methods: {
            activeClass (child) {
                var activeClass = [];
                if (Object.keys(child).length > 0) {
                    var _this = this;
                    Object.keys(child).forEach(index => {
                        if (child[index].name == _this.$route.name) {
                            activeClass = ['treeview', 'active'];
                        }
                    });
                }
                return activeClass;
            }
        }
    }
</script>