<template>
    <header id="header-navbar" class="content-mini content-mini-full">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right">
            <li>
                <div class="btn-group">
                    <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                        <img  :src="thisUser.avatar" :alt="thisUser.name">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Profile</li>
                        <li>
                            <a tabindex="-1" href="base_pages_inbox.html">
                                <i class="si si-envelope-open pull-right"></i>
                                <span class="badge badge-primary pull-right">3</span>收件箱
                            </a>
                        </li>
                        <li>
                            <router-link tabindex="-1" :to="'/dashboard/profile'">
                                <i class="si si-user pull-right"></i>个人中心
                            </router-link>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Actions</li>
                        <li>
                            <a tabindex="-1" href="base_pages_lock.html">
                                <i class="si si-lock pull-right"></i>锁定账户
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" @click.prevent="doLogout" href="javascript:;">
                                <i class="si si-logout pull-right"></i>注销账户
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
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
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
                <!-- Opens the Apps modal found at the bottom of the page, before including JS code -->
                <a href="/" class="btn btn-default pull-right" data-toggle="tooltip" title="返回首页" data-placement="bottom">
                    <i class="si si-grid"></i>
                </a>
            </li>
            <li class="visible-xs">
                <!-- Toggle class helper (for .js-header-search below), functionality initialized in App() -> uiToggleClass() -->
                <button class="btn btn-default" data-toggle="class-toggle" data-target=".js-header-search" data-class="header-search-xs-visible" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </li>
            <li class="js-header-search header-search">
                <form class="form-horizontal" action="#" method="post">
                    <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                        <input class="form-control" type="text" id="base-material-text" name="base-material-text" placeholder="Search..">
                        <span class="input-group-addon"><i class="si si-magnifier"></i></span>
                    </div>
                </form>
            </li>
        </ul>
        <!-- END Header Navigation Left -->
    </header>
</template>

<script>
    export default {
        data() {
            return {
                thisUser: {},
            }
        },
        created() {
            var _self = this;
            axios.get('/api/profile')
                .then(function (res) {
                    _self.thisUser = res.data.data;
                })
                .catch(function (res) {
                    console.log(res);
                });            
        },
        methods: {
            doLogout() {
                axios.post('/api/logout')
                    .then(function (res) {
                        if (res.data.code == 10000){
                            localStorage.removeItem("token");
                            window.location.href = "/login";
                        }else{
                            sweetAlert.error();
                        }
                    });
            },
            sidebarMiniToggle() {
                let winW = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                if (winW > 991){
                    $(this).toggleClass('sidebar-mini');
                }
                this.$store.commit('sidebarMiniToggle');
            }
        }
    }
</script>

<style>

</style>
