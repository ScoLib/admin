<template>
    <ul class="submenu">
        <template v-for="child in childs">
            <li v-if="child.name == '#'">
                <a href="#" :class="{ 'dropdown-toggle' : Object.keys(child.child).length > 0 }">
                    <i :class="['menu-icon', 'fa', child.icon ? child.icon : '']"></i>
                    <span class="menu-text">1 {{ child.display_name }} </span>
                </a>
                <b class="arrow"></b>
                <Submenu v-if="Object.keys(child.child).length > 0" :childs="child.child"></Submenu>
            </li>
            <router-link tag="li"
                         v-if="child.name != '#'"
                         :to="{ name: child.name }"
                         exact
            >
                <a :class="{ 'dropdown-toggle' : Object.keys(child.child).length > 0 }">
                    <i :class="['menu-icon', 'fa', child.icon ? child.icon : '']"></i>
                    <span class="menu-text"> {{ child.display_name }} </span>
                </a>
                <b class="arrow"></b>
                <Submenu v-if="Object.keys(child.child).length > 0" :childs="child.child"></Submenu>
            </router-link>
        </template>
    </ul>

</template>

<script>
    export default {
        props: ['childs']
    }
</script>