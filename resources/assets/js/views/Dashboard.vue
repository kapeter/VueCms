<template>
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed" :class="{ 'sidebar-mini' : isMini }">
        <Sidebar></Sidebar>
        <HeaderBar></HeaderBar>
        <main id="main-container">
            <transition mode="out-in" enter-active-class="animated lightSpeedIn" leave-active-class="animated lightSpeedOut">
                <router-view></router-view>
            </transition>
        </main>
        <FooterBar></FooterBar>
    </div>
</template>

<script>
    import Sidebar from '../components/layouts/Sidebar.vue';
    import HeaderBar from '../components/layouts/HeaderBar.vue';
    import FooterBar from '../components/layouts/FooterBar.vue';

    export default {
        components: {
            Sidebar,
            HeaderBar,
            FooterBar,
        },
        computed: {
            isMini() {
                return this.$store.state.isMini;
            }
        }
    }
</script>