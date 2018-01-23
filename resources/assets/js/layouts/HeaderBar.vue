<template>
    <header id="header-navbar" class="content-mini content-mini-full">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right">
            <li>
                <a :href="frontend_site" class="btn btn-default pull-right" title="返回前台" target="_blank">
                    <i class="fa fa-external-link"></i>
                </a>
            </li>
            <li>
                <div class="btn-group" :class="{ open: isOpen }">
                    <button class="btn btn-default btn-image dropdown-toggle" type="button" @click="isOpen = !isOpen">
                        <img  :src="thisUser.avatar" :alt="thisUser.name">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Profile</li>
                        <li>
                            <router-link tabindex="-1" :to="'/mail'">
                                <i class="fa fa-envelope pull-right"></i>
                                <span class="badge badge-info pull-right">3</span>收件箱
                            </router-link>
                        </li>
                        <li>
                            <router-link tabindex="-1" :to="'/profile'">
                                <i class="fa fa-user pull-right"></i>个人中心
                            </router-link>
                        </li>
                        <li>
                            <router-link tabindex="-1" :to="'/setting/system'">
                                <i class="fa fa-cogs pull-right"></i>系统设置
                            </router-link>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Actions</li>
                        <li>
                            <a tabindex="-1" href="base_pages_lock.html">
                                <i class="fa fa-lock pull-right"></i>锁定账户
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" @click.prevent="doLogout" href="javascript:;">
                                <i class="fa fa-sign-out pull-right"></i>注销账户
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- END Header Navigation Right -->

        <!-- Header Navigation Left -->
        <ul class="nav-header pull-left">
            <li class="hidden-md hidden-lg">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" type="button" @click='sidebarMiniToggle'>
                    <i class="fa fa-navicon"></i>
                </button>
            </li>
            <li class="hidden-xs hidden-sm">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" type="button" @click= 'sidebarMiniToggle'>
                    <i class="fa fa-ellipsis-v"></i>
                </button>
            </li>
            <li>
                <router-link :to="{ name: 'createPost' }" active-class='none' class="btn btn-default" data-toggle="tooltip" title="新增文章" data-placement="bottom">
                    <i class="fa fa-pencil"></i>
                </router-link>
            </li>
        </ul>
        <!-- END Header Navigation Left -->
    </header>
</template>

<script>
    export default {
        data() {
            return {
                frontend_site: '/',
                isOpen: false
            }
        },
        computed: {
            thisUser() {
                return this.$store.state.theUser;
            },
            theConf() {
                return this.$store.state.theConf;
            }
        },
        watch: {
            theConf (configs) {
                if (configs.length > 0) {
                    for (let i = 0; i < configs.length; i++){
                        if (configs[i].name == 'site_url'){
                            this.frontend_site = configs[i].value;
                        }
                    }
                } 
            }
        },
        methods: {
            doLogout() {
                let _self = this;
                _self.$store.dispatch('logout').then(() => {
                    _self.$router.push({ path: '/login' });
                }).catch(err => {
                    console.log(res);
                });                       
            },
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
