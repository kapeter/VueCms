<template>
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed" :class="{ 'sidebar-mini' : isMini }">
        <div class="loading" v-if="isLoading">
            <div class="loading-box">
                <img src="/img/loading.gif">
                <p>加载什么的最讨厌啦！</p>                
            </div>
        </div>
        <Sidebar></Sidebar>
        <HeaderBar></HeaderBar>
        <main id="main-container">
            <router-view></router-view>
        </main>
        <FooterBar></FooterBar>
    </div>
</template>

<script>
    import Sidebar from '../../components/dashboard/layouts/Sidebar.vue';
    import HeaderBar from '../../components/dashboard/layouts/HeaderBar.vue';
    import FooterBar from '../../components/dashboard/layouts/FooterBar.vue';

    export default {
        components: {
            Sidebar,
            HeaderBar,
            FooterBar,
        },
        data() {
            return {
                isLoading : true,
            }
        },
        mounted() {
            let hWindow     = $(window).height();
            var hHeader     = $('#header-navbar').outerHeight();
            var hFooter     = $('#page-footer').outerHeight();

            if ($('#page-container').hasClass('header-navbar-fixed')) {
                $('#main-container').css('min-height', hWindow - hFooter);
            } else {
                $('#main-container').css('min-height', hWindow - (hHeader + hFooter));
            }
            this.$nextTick(function () {
               this.isLoading = false;
            });
        },
        computed: {
            isMini() {
                return this.$store.state.isMini;
            }
        }
    }
</script>

<style>
    .loading{
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 9999;
        text-align: center;
        background: #fff;
    }
    .loading-box{
        width: 160px;
        height: 180px;
        position: absolute;
        left:50%;
        top: 50%;
        margin-top: -90px;
        margin-left: -80px;
    }
</style>
