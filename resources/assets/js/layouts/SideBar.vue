<template>
    <nav id="sidebar">
        <!-- Sidebar Scroll Container -->
        <div id="sidebar-scroll">
            <!-- Sidebar Content -->
            <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="side-header side-content">
                    <button class="btn btn-link text-white pull-right hidden-md hidden-lg"  @click='sidebarMiniToggle'>
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
                        <li>
                            <router-link to="/" exact>
                                <i class="fa fa-dashboard"></i><span class="sidebar-mini-hide">仪表盘</span>
                            </router-link>                            
                        </li>
                        <li v-for= "menu in menus" :class = "{ 'nav-main-heading' : !('url' in menu) }">
                            
                            <router-link v-if=" 'url' in menu " :to="'/' + menu.url" exact>
                                <i :class="menu.icon"></i><span class="sidebar-mini-hide">{{ menu.name }}</span>
                            </router-link>

                            <span v-else class="sidebar-mini-hide">{{ menu.name }}</span>
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
   import menus from '../config/menus.js'

    export default {
        data () {
            return {
                menus: menus,
            }
        },
        methods: {
            sidebarMiniToggle() {
                let winW = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                if (winW > 991){
                    this.$store.commit('sidebarMiniToggle');    
                }else{
                    this.$store.commit('sidebarHideenToggle');
                }
            }
        }

    }
</script>

<style>
</style>