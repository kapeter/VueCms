<template>
	<div>
		<page-heading title="系统设置" subTitle="System Settings" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
        	<div class="row">
        		<div class="col-lg-9 col-md-8">
			        <!-- Block Tabs Alternative Style -->
                    <div class="block">
                        <form>
                            <el-tabs v-model="tabActiveName">
                                <el-tab-pane label="基础设置" name="basic">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                            <div class="form-group" v-for="item in devideTab(settingData,'basic')">
                                                <label :for="item.name">
                                                    {{ item.title }}
                                                    <span class="font-s13" v-if="item.info">（<i class="fa fa-info"></i> {{ item.info }}）</span>
                                                </label>
                                                <input type="text" :name="item.name" v-model="item.value" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>
                                <el-tab-pane label="用户设置" name="user">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                            <div class="form-group" v-for="item in devideTab(settingData,'user')">
                                                <label :for="item.name">{{ item.title }}</label>
                                                <input type="text" :name="item.name" v-model="item.value" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>
                                <el-tab-pane label="自定义设置" name="diy">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                            <div class="form-group" v-for="item in devideTab(settingData,'diy')">
                                                <label :for="item.name">{{ item.title }}</label>
                                                <input type="text" :name="item.name" v-model="item.value" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>
                            </el-tabs>
                            <div class="block-content block-content-full text-center">
                            <button class="btn btn-info" type="submit" @click.prevent="submitData()"><i class="fa fa-check push-5-r"></i> 保存设置 </button>
                            <button class="btn btn-warning" @click.prevent="resetData()"><i class="fa fa-refresh push-5-r"></i> 重置表单 </button>
                            </div>
                        </form>
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
									<tr v-for="item in systemData.system">
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
                                    <tr v-for="item in systemData.database">
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
                	system: 'setting/system',
                    setting: 'setting'
                },
                systemData: [],
                settingData: [],
                tabActiveName: 'basic'
			}
		},
		mounted() {
            this.loadSystemData();
            this.loadSettingData();
		},
        methods: {
            loadSystemData () {
                let _self = this;
                _self.$http.get(_self.routeUrl.system)
                    .then(function (res) {
                        _self.systemData = res.data;
                    });  
            },
            loadSettingData () {
                let _self = this;
                _self.$http.get(_self.routeUrl.setting)
                    .then(function (res) {
                        _self.settingData = res.data.settings;
                    });  
            },
            devideTab(data, type) {
                return data.filter((item) => {
                    return item.type == type
                });
            },
            submitData() {
                let _self = this;
                _self.$http.post(_self.routeUrl.setting, _self.settingData)
                    .then(function(res){
                        _self.$message.success();
                        _self.resetData();
                    })
                    .catch(function (err) {
                        _self.$message.error();
                    })
            },
            resetData() {
                this.loadSettingData();
            }
        }
	}
</script>