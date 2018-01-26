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
                        <div v-for= "(model, index) in menuList">
                            <li class="nav-main-heading">
                                <span class="sidebar-mini-hide">{{ model.name }}</span>
                            </li>
                            <li v-for="menu in menuList[index].children">
                                <router-link :to="'/' + menu.url" exact>
                                    <i :class="menu.icon"></i><span class="sidebar-mini-hide">{{ menu.name }}</span>
                                </router-link>                                
                            </li>
                        </div>
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
   import menus from '../config/menus'

    export default {
        data () {
            return {
                menuList: [],
            }
        },
        mounted() {
            if (this.$store.state.theUser.role.is_admin){
                this.menuList = menus;
                return false;
            }
            for (let i = 0; i < menus.length; i++){
                let children = [];
                for (let j = 0; j < menus[i].children.length; j++){
                    if (this.has(menus[i].children[j].url, 'browser')){
                        children.push(menus[i].children[j])
                    }
                }
                if (children.length > 0){
                    this.menuList.push({
                        name: menus[i].name,
                        children: children
                    })
                }
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
            },

            has(route, handle) {
                let permissions = this.$store.state.permissions;
                for (let i = 0; i < permissions.length; i++){
                    if (permissions[i].route == route){
                        if (permissions[i]['can_' + handle] == 1 || permissions[i].is_except){
                            return true;
                        }else{
                            return false;
                        }
                        break;
                    }
                }
                return false;
            }
        }

    }
</script>

<style>
</style>