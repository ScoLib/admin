<template>
    <ul class="submenu">
        <router-link tag="li"
                     :to="child.name == '#' ? {path:'#'} : { name: child.name}"
                     exact
                     v-for="child in childs"
        >
            <a :class="{ 'dropdown-toggle' : Object.keys(child.child).length > 0 }">
                <i :class="child.icon"></i>
                <span class="menu-text"> {{ child.display_name }} </span>
            </a>
            <b class="arrow"></b>
            <item v-if="Object.keys(child.child).length > 0" :childs="child.child"></item>
        </router-link>
    </ul>

</template>

<script>
    export default {
        props: ['childs']
    }
</script>