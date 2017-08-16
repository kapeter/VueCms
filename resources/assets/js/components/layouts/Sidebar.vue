<template>
    <nav id="sidebar">
        <!-- Sidebar Scroll Container -->
        <div id="sidebar-scroll">
            <!-- Sidebar Content -->
            <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="side-header side-content">
                    <button class="btn btn-link text-white pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times"></i>
                    </button>
                    <router-link class="h5 text-white" to="/">
                        <img src="/img/logo-sm.png" alt="kapeter">
                        <span class="h4 sidebar-mini-hide">&nbsp;VueCMS</span>
                    </router-link >
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="side-content">
                    <ul class="nav-main">
                        <li v-for= "menu in menus" :class = "{ 'nav-main-heading' : !('icon' in menu), 'open' : ('isOpen' in menu && menu.isOpen) }">

                            <a v-if=" 'children' in menu " href="javascript:;" class="nav-submenu" @click="toggleSubMenu(menu)">
                                <i :class="menu.icon"></i><span class="sidebar-mini-hide">{{ menu.name }}</span>
                            </a>
                            
                            <router-link v-else-if=" 'icon' in menu " :to="menu.uri" exact>
                                <i :class="menu.icon"></i><span class="sidebar-mini-hide">{{ menu.name }}</span>
                            </router-link>

                            <span v-else class="sidebar-mini-hide">{{ menu.name }}</span>

                            <ul v-if="'children' in menu">
                                <li v-for="child in menu.children">
                                    <router-link :to="child.uri" exact>{{ child.name }}</router-link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- END Side Content -->
            </div>
            <!-- Sidebar Content -->
        </div>
        <!-- END Sidebar Scroll Container -->
    </nav>
</template>

<script>
   import menus from '../../config/menus.js'

    export default {
        data () {
            return {
                menus: menus,
            }
        },
        methods: {
            toggleSubMenu(menu) {
                menu.isOpen = !menu.isOpen;
                for (let i = 0; i<this.menus.length; i++){
                    if ('isOpen' in this.menus[i] && this.menus[i].name != menu.name){
                        this.menus[i].isOpen = false;
                    }
                }
            }
        }

    }
</script>

<style>
</style>