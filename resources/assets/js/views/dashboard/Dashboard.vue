<template>
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
        <Sidebar></Sidebar>
        <HeaderBar></HeaderBar>
        <router-view></router-view>
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
            FooterBar
        },
    }
</script>

<style>
</style>
