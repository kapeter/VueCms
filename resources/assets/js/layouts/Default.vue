<template>
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed" 
        :class="{ 'sidebar-mini' : isMini, 'sidebar-o-xs' : isHideen }">
        <SideBar></SideBar>
        <HeaderBar></HeaderBar>
        <main id="main-container" :style="{ 'min-height' : minH + 'px' }">
            <transition mode="out-in" enter-active-class="animated fadeInRight" leave-active-class="animated fadeOutRight">
                <router-view></router-view>
            </transition>
        </main>
        <FooterBar></FooterBar>            
    </div>
</template>

<script>
    import SideBar from './SideBar.vue'
    import HeaderBar from './HeaderBar.vue'
    import FooterBar from './FooterBar.vue'

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

                    resizeTimeout = setTimeout(() => {
                        _self.minH = window.outerHeight - 110;
                    }, 300);
                    
                }                
            }
        }
    }
</script>