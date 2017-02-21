<template>
	<main id="main-container">
	    <!-- Page Header -->
	    <div class="bg-image overflow-hidden" style="background-image: url('/img/header-bg.jpg');">
	        <div class="bg-black-op">
	            <div class="content content-narrow">
	                <div class="block block-transparent">
	                    <div class="block-content block-content-full">
	                        <h1 class="h1 font-w300 text-white animated fadeInDown push-50-t push-5">Dashboard</h1>
	                        <h2 class="h4 font-w300 text-white-op animated fadeInUp">Welcome Administrator</h2>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- END Page Header -->
	    
        <!-- Page Content -->
        <div class="content content-narrow">
            <!-- Stats -->
            <div class="row text-uppercase">
                <div class="col-xs-6 col-sm-3">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div class="text-muted">
                                <small><i class="si si-calendar"></i> Today</small>
                            </div>
                            <div class="font-s12 font-w700">Unq Visitors</div>
                            <a class="h2 font-w300 text-primary" href="base_comp_charts.html" data-toggle="countTo" data-to="480950"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div class="text-muted">
                                <small><i class="si si-calendar"></i> Today</small>
                            </div>
                            <div class="font-s12 font-w700">Prd Sales</div>
                            <a class="h2 font-w300 text-primary" href="base_comp_charts.html" data-toggle="countTo" data-to="495"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div class="text-muted">
                                <small><i class="si si-calendar"></i> Today</small>
                            </div>
                            <div class="font-s12 font-w700">Earnings</div>
                            <a class="h2 font-w300 text-primary" href="base_comp_charts.html" data-toggle="countTo" data-to="148000" data-before="$"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div class="text-muted">
                                <small><i class="si si-calendar"></i> Today</small>
                            </div>
                            <div class="font-s12 font-w700">Average Sale</div>
                            <a class="h2 font-w300 text-primary" href="#" data-toggle="countTo" data-to="299" data-before="$"></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Stats -->

            <!-- Dashboard Charts -->
            <div class="row">
                <div class="col-md-6">
                    <div class="block block-rounded block-opt-refresh-icon8">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Earnings in $</h3>
                        </div>
                        <div class="block-content block-content-full bg-gray-lighter text-center">
                            <!-- Chart.js Charts (initialized in js/pages/base_pages_dashboard_v2.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                            <div style="height: 340px;"><canvas class="js-dash-chartjs-earnings"></canvas></div>
                        </div>
                        <div class="block-content text-center">
                            <div class="row items-push-2x text-center push-20-t">
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-bank fa-2x"></i></div>
                                    <div class="h5 text-muted">$148,000</div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-angle-double-up fa-2x"></i></div>
                                    <div class="h5 text-muted">+9% Earnings</div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-headphones fa-2x"></i></div>
                                    <div class="h5 text-muted">+20% Tickets</div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-users fa-2x"></i></div>
                                    <div class="h5 text-muted">+46% Clients</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="block block-rounded block-opt-refresh-icon8">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Sales</h3>
                        </div>
                        <div class="block-content block-content-full bg-gray-lighter text-center">
                            <!-- Chart.js Charts (initialized in js/pages/base_pages_dashboard_v2.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                            <div style="height: 340px;"><canvas class="js-dash-chartjs-sales"></canvas></div>
                        </div>
                        <div class="block-content text-center">
                            <div class="row items-push-2x text-center push-20-t">
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-wordpress fa-2x"></i></div>
                                    <div class="h5 text-muted">+20% Themes</div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-font fa-2x"></i></div>
                                    <div class="h5 text-muted">+25% Fonts</div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-archive fa-2x"></i></div>
                                    <div class="h5 text-muted">-10% Icons</div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="push-15"><i class="fa fa-paint-brush fa-2x"></i></div>
                                    <div class="h5 text-muted">+8% Graphics</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Dashboard Charts -->

            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-lg-4">
                    <!-- Add Friend -->
                    <div class="bg-image" style="background-image: url('assets/img/photos/photo29.jpg');">
                        <div class="bg-black-op">
                            <div class="block block-themed block-transparent">
                                <div class="block-header">
                                    <h3 class="block-title text-center">Friend Suggestion</h3>
                                </div>
                                <div class="block-content text-center">
                                    <div class="push">
                                        <img class="img-avatar img-avatar96 img-avatar-thumb" src="assets/img/avatars/avatar10.jpg" alt="">
                                    </div>
                                    <h3 class="font-w300 text-white">Eugene Burke</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <a class="btn btn-sm btn-default" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-plus text-success"></i> Add friend
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Add Friend -->
                </div>
                <div class="col-lg-4">
                    <!-- Category -->
                    <div class="bg-image" style="background-image: url('assets/img/photos/photo28.jpg');">
                        <div class="bg-black-op">
                            <div class="block block-themed block-transparent">
                                <div class="block-header">
                                    <ul class="block-options">
                                        <li>
                                            <button type="button"><i class="si si-settings"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Category</h3>
                                </div>
                                <div class="block-content block-content-full text-center push-50-t push-50">
                                    <a class="h1 font-w300 text-white" href="javascript:void(0)">Photography</a>
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
                    <!-- Weather -->
                    <div class="block">
                        <div class="bg-image" style="background-image: url('assets/img/photos/photo33.jpg');">
                            <div class="bg-black-op">
                                <div class="block-content text-center">
                                    <h3 class="h2 font-w300 text-uppercase text-white push-50-t">San Francisco</h3>
                                    <h4 class="h5 text-white-op push-50">California, US</h4>
                                </div>
                                <div class="block-content block-content-full text-center bg-black-op">
                                    <div class="row push-5-t push-5">
                                        <div class="col-xs-4">
                                            <div class="h2 font-w300 text-white">24&deg;C</div>
                                            <div class="h5 text-muted push-5-t">MON</div>
                                        </div>
                                        <div class="col-xs-4">
                                            <div class="h2 font-w300 text-white">26&deg;C</div>
                                            <div class="h5 text-muted push-5-t">TUE</div>
                                        </div>
                                        <div class="col-xs-4">
                                            <div class="h2 font-w300 text-white">25&deg;C</div>
                                            <div class="h5 text-muted push-5-t">WED</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Weather -->
                </div>
            </div>
            <!-- END Dashboard Cards -->
        </div>
        <!-- END Page Content -->    	
	</main>
</template>

<script>
    import countTo from '../../../plugins/jquery.countTo.min.js'

    export default {
        mounted() {
            $('[data-toggle="countTo"]').each(function () {
                let MycountTo = $(this);
                let countToBefore = MycountTo.data('before');
                let countToAfter = MycountTo.data('after');
                MycountTo.countTo({
                    speed: 1000,
                    refreshInterval: 15,
                    onComplete: function() {
                        if(countToAfter) {
                            MycountTo.html(MycountTo.html() + countToAfter);
                        } else if (countToBefore) {
                            MycountTo.html(countToBefore + MycountTo.html());
                        }
                    }
                });
            });

        }
    }
</script>

