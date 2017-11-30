<template>
	<div>	    
        <!-- Page Content -->
        <div class="content">
            <!-- Stats -->
            <div class="row">
                <div class="col-xs-12 col-lg-3 col-md-4">
                  <!-- Panel Web Designer -->
                    <div class="bg-info" style="background:-webkit-linear-gradient(right, #39c5bb, #39c5ee)">
                        <div class="block block-themed block-transparent">
                            <div class="block-content text-center">
                                <div class="push push-30-t">
                                    <img class="img-avatar img-avatar128 img-avatar-thumb" :src="thisUser.avatar" :alt="thisUser.name">
                                </div>
                                <div class="push-30 text-white-op">
                                    <h3 class="font-w400 text-white push-5">{{ thisUser.name }}</h3>
                                    <h5>{{ 'role' in thisUser ? thisUser.role.title : '编辑者' }}</h5>
                                    <p class="push-30-t">上次登录时间<br>2017-07-04 15:36:23</p>
                                    <p>上次登录IP<br>10.0.0.2</p>
                                </div>
                            </div>
                        </div>                        
                    </div>
                  <!-- End Panel Web Designer -->
                </div>
                <div class="col-xs-12 col-lg-9 col-md-8">
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

