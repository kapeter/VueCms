<template>
	<div>
		<page-heading title="系统设置" subTitle="System Settings" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
        	<div class="row">
        		<div class="col-lg-9 col-md-8">
			        <!-- Block Tabs Alternative Style -->
                    <div class="block">
                        <el-tabs v-model="tabActiveName">
                            <el-tab-pane label="基础设置" name="basic">基础设置</el-tab-pane>
                            <el-tab-pane label="用户设置" name="user">用户设置</el-tab-pane>
                            <el-tab-pane label="自定义设置" name="diy">自定义设置</el-tab-pane>
                        </el-tabs>
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
									<tr v-for="item in system">
										<td class="font-w600">{{ item.label }}</td>
										<td class="text-right">{{ item.value }}</td>
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
                            <table class="table table-borderless">
                                <tbody>
                                    <tr v-for="item in system">
                                        <td class="font-w600">{{ item.label }}</td>
                                        <td class="text-right">{{ item.value }}</td>
                                    </tr>
                                </tbody>
                            </table>
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
                routeUrl: {
                	systemUrl: 'setting/system'
                },
                system: [],
                tabActiveName: 'basic'
			}
		},
		mounted() {
			let _self = this;
			_self.$http.get(_self.routeUrl.systemUrl)
				.then(function (res) {
					_self.system = res.data;
				});
		}
	}
</script>