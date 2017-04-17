<template>
    <ul class="submenu">
        <router-link tag="li"
                     v-for="child in childs"
                     :to="child.name == '#' ? notUrl : {name: child.name}"
                     exact
        >
            <a :class="{ 'dropdown-toggle' : Object.keys(child.child).length > 0 }">
                <i :class="['menu-icon', 'fa', child.icon ? child.icon : 'fa-caret-right']"></i>
                <span class="menu-text"> {{ child.display_name }} </span>
            </a>
            <b class="arrow"></b>
            <Submenu v-if="Object.keys(child.child).length > 0" :childs="child.child"></Submenu>
        </router-link>
    </ul>

</template>

<script>
    export default {
        props: ['childs'],
        computed: {
            notUrl () {
                return '/#';
            }
        }
    }
</script>