<template>
	<div>
		<page-heading title="系统设置" subTitle="System Settings" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
        	<div class="row">
        		<div class="col-lg-9 col-md-8">
			        <!-- Block Tabs Alternative Style -->
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                            <li class="active">
                                <a href="#basic-setting">基本设置</a>
                            </li>
                            <li>
                                <a href="#user-setting">用户设置</a>
                            </li>
                            <li>
                                <a href="#diy-setting">自定义设置</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active fade fade-up" id="basic-setting">
                                <h4 class="font-w300 push-15">Home Tab</h4>
                                <p>...</p>
                            </div>
                            <div class="tab-pane fade fade-up" id="user-setting">
                                <h4 class="font-w300 push-15">Profile Tab</h4>
                                <p>...</p>
                            </div>
                            <div class="tab-pane fade fade-up" id="diy-setting">
                                <h4 class="font-w300 push-15">Settings Tab</h4>
                                <p>...</p>
                            </div>
                        </div>
                    </div>
                    <!-- END Block Tabs Alternative Style -->
        		</div>
        		<div class="col-lg-3 col-md-4">

                    <!-- Gift Card -->
                    <div class="block block-rounded">
                        <div class="block-content block-content-full bg-info text-center">
                            <div class="push-10-t push-10">
                                <i class="fa fa-4x fa-android text-white-op push-10"></i>
                                <h3 class="h4 text-white">服务器环境</h3>
                            </div>
                        </div>
                        <div class="block-content block-content-full clearfix">
							<table class="table table-borderless">
								<tbody>
									<tr>
										<td class="font-w600">操作系统</td>
										<td class="text-right">CentOS</td>
									</tr>
								</tbody>
							</table>
                        </div>
                    </div>
                    <!-- END Gift Card -->
                    <div class="block block-rounded">
                        <div class="block-content block-content-full bg-info text-center">
                            <div class="push-10-t push-10">
                                <i class="fa fa-4x fa-database text-white-op push-10"></i>
                                <h3 class="h4 text-white">数据库环境</h3>
                            </div>
                        </div>
                        <div class="block-content block-content-full clearfix">
                            <div class="pull-right">
                                <a class="btn btn-sm btn-default" href="javascript:void(0)">Buy Now!</a>
                            </div>
                            <div class="pull-left">
                                <div class="h3">$50,00</div>
                            </div>
                        </div>
                    </div>        			
        		</div>
        	</div>
        </div>
        <!-- END Page Content -->
	</div>
</template>

<script>
	export default {
		data() {
			return {
				crumbs: [
                    {to: null, text: '系统设置'},
                ],
			}
		}
	}
</script>