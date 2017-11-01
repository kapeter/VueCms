<template>
	<div>
	    <!-- Page Header -->
        <div class="bg-image overflow-hidden" style="background-image: url('/img/header-bg.jpg');">
            <div class="content">
                <div class="block block-transparent">
                    <div class="block-content block-content-full">
                        <h1 class="h1 font-w300 push-50-t push-5">Hello, Master</h1>
                        <h2 class="h5 font-w300">Always believe that something wonderful is about to happen.</h2>
                    </div>
                </div>
            </div>
        </div>

	    <!-- END Page Header -->
	    
        <!-- Page Content -->
        <div class="content">
            <!-- Stats -->
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                  <!-- Panel Web Designer -->
                    <div class="bg-info" style="background:-webkit-linear-gradient(right, #39c5bb, #39c5ee)">
                    <div class="block block-themed block-transparent">
                        <div class="block-content text-center">
                            <div class="push push-30-t">
                                <img class="img-avatar img-avatar96 img-avatar-thumb" :src="thisUser.avatar" :alt="thisUser.name">
                            </div>
                            <div class="push-30">
                                <h2 class="block-title push-5 text-white">{{ thisUser.name }}</h2>
                                <h3 class="h5 text-white-op">{{ userRole }}</h3>
                                <p class="push-30-t text-white-op">上次登录时间<br>2017-07-04 15:36:23</p>
                            </div>
                        </div>
                    </div>                        
                    </div>

                  <!-- End Panel Web Designer -->
                    <!-- Category -->
                    <div class="bg-city-light">
                        <div class="block block-themed block-transparent">
                            <div class="block-header">
                                <h3 class="block-title">邮箱动态<span class="pull-right">unread / 625</span></h3>
                            </div>
                            <div class="block-content block-content-full text-center new-block">
                                <h1 class="text-white font-s72 font-w300">
                                    <i class="si si-notebook"></i>
                                </h1>
                            </div>
                            <div class="block-content block-content-full text-center">
                                <a class="text-white" href="#">永远相信美好的事即将发生</a><br>
                                <span class="text-white-op font-s12"><em>Updated 10 hours ago</em></span>
                            </div>
                        </div>
                    </div>
                    <!-- END Category -->
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="block block-rounded block-opt-refresh-icon8">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title"><i class="si si-calendar"></i> 近期动态</h3>
                        </div>
                        <div class="block-content block-content-full bg-gray-lighter">
                            <ul class="list list-timeline pull-t">
                                <!-- Facebook Notification -->
                                <li>
                                    <div class="list-timeline-time">3 hrs ago</div>
                                    <i class="fa fa-facebook list-timeline-icon bg-default"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">+ 290 Page Likes</p>
                                        <p class="font-s13">This is great, keep it up!</p>
                                    </div>
                                </li>
                                <!-- END Facebook Notification -->

                                <!-- System Notification -->
                                <li>
                                    <div class="list-timeline-time">1 day ago</div>
                                    <i class="fa fa-database list-timeline-icon bg-smooth"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">Database backup completed!</p>
                                        <p class="font-s13">Download the <a href="javascript:void(0)">latest backup</a>.</p>
                                    </div>
                                </li>
                                <!-- END System Notification -->
                                
                                <!-- Photo Notification -->
                                <li>
                                    <div class="list-timeline-time">4 hrs ago</div>
                                    <i class="fa fa-picture-o list-timeline-icon bg-flat"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">+ 3 New Photos</p>
                                        <p class="font-s13">Travel hacks and ideas!</p>
                                        <!-- Gallery (.js-gallery class is initialized in App() -> uiHelperMagnific()) -->
                                        <!-- For more info and examples you can check out http://dimsemenov.com/plugins/magnific-popup/ -->
                                        <div class="row items-push js-gallery">
                                            <div class="col-sm-6 col-lg-4">
                                                <a class="img-link" href="assets/img/photos/photo2@2x.jpg">
                                                    <img class="img-responsive" src="/img/photo28.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-lg-4">
                                                <a class="img-link" href="assets/img/photos/photo8@2x.jpg">
                                                    <img class="img-responsive" src="/img/photo29.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-lg-4">
                                                <a class="img-link" href="assets/img/photos/photo16@2x.jpg">
                                                    <img class="img-responsive" src="/img/photo33.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- END Photos Notification -->

                                <!-- System Notification -->
                                <li>
                                    <div class="list-timeline-time">1 day ago</div>
                                    <i class="fa fa-database list-timeline-icon bg-smooth"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">Database backup completed!</p>
                                        <p class="font-s13">Download the <a href="javascript:void(0)">latest backup</a>.</p>
                                    </div>
                                </li>
                                <!-- END System Notification -->

                                <!-- System Notification -->
                                <li>
                                    <div class="list-timeline-time">1 week ago</div>
                                    <i class="fa fa-cog list-timeline-icon bg-primary-dark"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600">System updated to v2.02</p>
                                        <p class="font-s13">Check the complete changelog at the <a href="javascript:void(0)">activity page</a>.</p>
                                    </div>
                                </li>
                                <!-- END System Notification -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Stats -->
        </div>
        <!-- END Page Content -->    	
	</div>
</template>

<script>
    export default {
        computed: {
            thisUser() {
                return this.$store.state.theUser;
            },
            userRole() {
                return this.thisUser.is_admin == true ? '系统管理员' : '编辑者';
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

