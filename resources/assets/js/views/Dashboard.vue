<template>
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed" 
        :class="{ 'sidebar-mini' : isMini, 'sidebar-o-xs' : isHideen }">
        <div v-if="isLogin">
            <SideBar></SideBar>
            <HeaderBar></HeaderBar>
            <main id="main-container" :style="{ 'min-height' : minH + 'px' }">
                <transition mode="out-in" enter-active-class="animated lightSpeedIn" leave-active-class="animated lightSpeedOut">
                    <router-view></router-view>
                </transition>
            </main>
            <FooterBar></FooterBar>            
        </div>
        <div class="loading" v-else>
            <div class="loading-box">
                <img src="/img/loading.gif"> 
                <p>加载什么的最讨厌啦</p>              
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from '../components/layouts/SideBar.vue'
    import HeaderBar from '../components/layouts/HeaderBar.vue'
    import FooterBar from '../components/layouts/FooterBar.vue'

    export default {
        components: {
            SideBar,
            HeaderBar,
            FooterBar
        },
        data () {
            return {
                minH: 0
            }
        },
        computed: {
            isMini() {
                return this.$store.state.isMini;
            },
            isHideen() {
                return this.$store.state.isHideen;
            },
            isLogin() {
                return this.$store.state.theUser != {}
            }
        },
        mounted () {
            this.setMinHeight();
            this.$store.dispatch('config')
        },
        methods: {
            setMinHeight() {
                let _self = this;
                let resizeTimeout = null;

                _self.minH = window.outerHeight- 110;

                window.onresize = () => {

                    clearTimeout(resizeTimeout);

                    resizeTimeout = setTimeout(function(){
                        _self.minH = window.outerHeight - 110;
                    }, 300);
                    
                }                
            }
        }
    }
</script>