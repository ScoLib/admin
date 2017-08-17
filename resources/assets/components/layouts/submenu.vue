<template>
    <ul :class="ulClass">
        <li class="header" v-if="isTop">MAIN NAVIGATION</li>

        <router-link
                tag="li"
                v-for="child in Object.values(childs)"
                :to="child.url ? child.url : '/#'"
                :class="activeClass(child.pages)"
                :key="child.id"
                exact>
            <a>
                <i :class="['fa', child.icon ? child.icon : 'fa-circle-o']"></i>
                <span v-if="isTop"> {{ child.title }} </span>
                <template v-else>{{ child.title }}</template>

                <span
                        class="pull-right-container"
                        v-if="Object.keys(child.pages).length > 0 || child.badges.length">
                    <i class="fa fa-angle-left pull-right"
                       v-if="Object.keys(child.pages).length > 0"></i>
                    <small
                            v-if="child.badges.length"
                            v-for="badge in child.badges"
                            :class="badge.class">
                        {{ badge.value }}
                    </small>
                </span>
            </a>
            <Submenu v-if="Object.keys(child.pages).length > 0" :childs="child.pages"></Submenu>
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
        },
        methods: {
            activeClass (child) {
                var activeClass = [];
                if (Object.keys(child).length > 0) {
                    var _this = this;
                    Object.keys(child).forEach(index => {
//                        console.log(child[index].url)
//                        console.log(_this.$route)
                        if (child[index].url == _this.$route.path) {
                            activeClass = ['treeview', 'active'];
                        }
                    });
                }
                return activeClass;
            }
        }
    }
</script>