<template>
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed" :class="{ 'sidebar-mini' : isMini }">
        <div v-if="isLogin">
            <Sidebar></Sidebar>
            <Header></Header>
            <main id="main-container">
                <transition mode="out-in" enter-active-class="animated lightSpeedIn" leave-active-class="animated lightSpeedOut">
                    <router-view></router-view>
                </transition>
            </main>
            <Footer></Footer>            
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
    import Sidebar from '../components/layouts/Sidebar.vue'
    import Header from '../components/layouts/Header.vue'
    import Footer from '../components/layouts/Footer.vue'

    export default {
        components: {
            Sidebar,
            Header,
            Footer
        },
        computed: {
            isMini() {
                return this.$store.state.isMini;
            },
            isLogin() {
                return this.$store.state.theUser != {}
            }
        }
    }
</script>