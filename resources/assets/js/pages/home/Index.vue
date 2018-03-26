<template>
	<div>	    
        <!-- Page Content -->
        <div class="content">
            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-lg-4">
                    <!-- Add Friend -->
                    <div class="bg-image" style="background-image: url('/img/bg1.jpg');">
                        <div class="bg-black-op">
                            <div class="block block-themed block-transparent">
                                <div class="block-header">
                                    <h3 class="block-title text-center">Current User</h3>
                                </div>
                                <div class="block-content text-center">
                                    <div class="push">
                                        <img class="img-avatar img-avatar96 img-avatar-thumb" :src="thisUser.avatar" :alt="thisUser.name">
                                    </div>
                                    <h3 class="font-w300 text-white">{{ thisUser.name }}</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <span class="text-white-op">{{ 'role' in thisUser ? thisUser.role.title : '编辑者' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Add Friend -->
                </div>
                <div class="col-lg-4">
                    <!-- Category -->
                    <div class="bg-image" style="background-image: url('/img/bg2.jpg');">
                        <div class="bg-black-op">
                            <div class="block block-themed block-transparent">
                                <div class="block-header">
                                    <h3 class="block-title text-center">Total Articles</h3>
                                </div>
                                <div class="block-content text-center">
                                    <div class="push">
                                        <div class="img-avatar img-avatar96 img-avatar-thumb" style="line-height: 96px">
                                            <i class="fa fa-book text-white font-s48" style="vertical-align: middle;"></i>
                                        </div>
                                    </div>
                                    <h3 class="font-w300 text-white">4 文章</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <span class="text-white-op"><em>Updated 10 hours ago</em></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Category -->
                </div>
                <div class="col-lg-4">
                    <!-- Category -->
                    <div class="bg-image" style="background-image: url('/img/bg3.jpg');">
                        <div class="bg-black-op">
                            <div class="block block-themed block-transparent">
                                <div class="block-header">
                                    <h3 class="block-title text-center">Total Comments</h3>
                                </div>
                                <div class="block-content text-center">
                                    <div class="push">
                                        <div class="img-avatar img-avatar96 img-avatar-thumb" style="line-height: 96px">
                                            <i class="fa fa-comments text-white font-s48" style="vertical-align: middle;"></i>
                                        </div>
                                    </div>
                                    <h3 class="font-w300 text-white">4 评论</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <span class="text-white-op"><em>Updated 10 hours ago</em></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Category -->
                </div>
            </div>
            <!-- END Dashboard Cards -->
        </div>
        <!-- END Page Content -->    	
	</div>
</template>

<script>
    export default {
        computed: {
            thisUser() {
                return this.$store.state.theUser;
            }
        },
        mounted() {
        }
    }
</script>

<style>
   .new-block{
        height: 115px;
        margin: 40px;
   } 
   .new-block > .h4{
        line-height: 1.5;
        letter-spacing: 1px;
   }
</style>

