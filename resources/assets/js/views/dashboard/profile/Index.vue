<template>
    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- User Header -->
        <div class="block">
            <!-- Basic Info -->
            <div class="block-content text-center overflow-hidden" style="background:-webkit-linear-gradient(right, #39c5bb, #39c5ee)">
                <div class="push-30-t push animated fadeInDown">
                    <img class="img-avatar img-avatar128 img-avatar-thumb" :src="thisUser.avatar" :alt="thisUser.name">
                </div>
                <div class="push-30 animated fadeInUp">
                    <h2 class="h3 font-w600 text-white push-5">{{ thisUser.name }}</h2>
                    <h3 class="h5 text-white-op">{{ userRole }}</h3>
                </div>
            </div>
            <!-- END Basic Info -->

            <!-- Stats -->
            <div class="block-content text-center">
                <div class="row items-push text-uppercase">
                    <div class="col-xs-6 col-sm-3">
                        <div class="font-w700 text-gray-darker animated fadeIn">Sales</div>
                        <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">22000</a>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="font-w700 text-gray-darker animated fadeIn">Products</div>
                        <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">16</a>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="font-w700 text-gray-darker animated fadeIn">Followers</div>
                        <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">2600</a>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="font-w700 text-gray-darker animated fadeIn">3603 Ratings</div>
                        <div class="text-warning push-10-t animated flipInX">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Stats -->
        </div>
        <!-- END User Header -->

        <!-- Main Content -->
        <form action="pages_profile_edit.html" method="post" onsubmit="return false;">
            <div class="block">
                <ul class="nav nav-tabs nav-justified push-20">
                    <li class="active">
                        <a href="#personal" data-toggle="tab"><i class="fa fa-fw fa-pencil"></i> 个人设置</a>
                    </li>
                    <li>
                        <a href="#password" data-toggle="tab"><i class="fa fa-fw fa-asterisk"></i> 密码设置</a>
                    </li>
                    <li>
                        <a href="#avatar" data-toggle="tab"><i class="fa fa-fw fa-photo"></i> 头像修改</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <!-- Personal Tab -->
                    <div class="tab-pane fade in active" id="personal">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label>邮箱地址</label>
                                        <div class="form-control-static font-w700">{{ thisUser.email }}</div>
                                    </div>
                                </div>
                                <div class="form-group" :class="{ 'has-error' : userName.hasError  }">
                                    <div class="col-xs-12">
                                        <label for="profile-email">用户名</label>
                                        <input class="form-control" type="text" id="profile-email" name="profile-email" v-model="userName.value">
                                        <div class="help-block animated fadeInDown" v-show="userName.hasError">用户名不能为空。</div>
                                    </div>
                                </div>
                                <div class="form-group" :class="{ 'has-error' : userBio.hasError  }">
                                    <div class="col-xs-12">
                                        <label for="profile-bio">个人签名</label>
                                        <textarea class="form-control" id="profile-bio" name="profile-bio" rows="10" v-model="userBio.value">
                                        </textarea>
                                        <div class="help-block animated fadeInDown" v-show="userBio.hasError">个人签名不能为空</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Personal Tab -->

                    <!-- Password Tab -->
                    <div class="tab-pane fade" id="password">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group" :class="{ 'has-error' : currentPwd.hasError  }">
                                    <div class="col-xs-12">
                                        <label for="profile-password">当前密码</label>
                                        <input class="form-control" type="password" v-model="currentPwd.value">
                                        <div class="help-block animated fadeInDown" v-show="currentPwd.hasError">当前密码不能为空</div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group" :class="{ 'has-error' : newPwd.hasError  }">
                                    <div class="col-xs-12">
                                        <label for="profile-password-new">新的密码</label>
                                        <input class="form-control" type="password" v-model="newPwd.value">
                                        <div class="help-block animated fadeInDown" v-show="newPwd.hasError">新密码不能与当前密码一致</div>
                                    </div>
                                </div>
                                <div class="form-group" :class="{ 'has-error' : newPwdConfirm.hasError  }">
                                    <div class="col-xs-12">
                                        <label for="profile-password-new-confirm">重复新的密码</label>
                                        <input class="form-control" type="password" v-model="newPwdConfirm.value">
                                        <div class="help-block animated fadeInDown" v-show="newPwdConfirm.hasError">两次输入的密码不一致</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Password Tab -->

                    <!-- Privacy Tab -->
                    <div class="tab-pane fade" id="avatar">
                        <div class="row">
                        </div>
                    </div>
                    <!-- END Privacy Tab -->
                </div>
                <div class="block-content block-content-full text-center">
                   
                    <button class="btn btn-sm btn-info" type="submit" @click.prevent="submitData()"><i class="fa fa-check push-5-r"></i> 保存设置 </button>
                    <button class="btn btn-sm btn-warning" @click.prevent="resetData()"><i class="fa fa-refresh push-5-r"></i> 表单重置 </button>
                </div>
            </div>
        </form>
        <!-- END Main Content -->
    </div>
    <!-- END Page Content -->
</template>

<script>
    export default {
        data() {
            return {
                thisUser: {},
                userName: {
                    value: '',
                    hasError: false,                   
                },
                userBio: {
                    value: '',
                    hasError: false,                   
                },
                currentPwd: {
                    value: '',
                    hasError: false,
                },
                newPwd: {
                    value: '',
                    hasError: false,
                },
                newPwdConfirm: {
                    value: '',
                    hasError: false,
                },

            }
        },
        computed: {
        	userRole() {
        		return this.thisUser.is_admin == true ? '系统管理员' : '编辑者';
        	}
        },
        created() {
           	this.loadData();
        },
        methods: {
        	loadData() {
	            let _self = this;
	            axios.get('/api/profile')
	                .then(function (res) {
	                    _self.thisUser = res.data.data;
	                    _self.userName.value = _self.thisUser.name;
                        _self.userBio.value = _self.thisUser.bio;
	                })
	                .catch(function (res) {
	                    console.log(res);
	                });         		
        	},
        	resetData() {
        		this.loadData();
        	},
        	submitData() {
        		let formData = new FormData();
                let _self = this;

                if (_self.userName.value == ''){
                     _self.userName.hasError = true;
                    return false;
                }else{
                    _self.userName.hasError = false;
                    formData.append('name',_self.userName.value);
                }

                if (_self.userBio.value == ''){
                    _self.userBio.hasError = true;
                    return false;
                }else{
                    _self.userBio.hasError = false;
                    formData.append('bio',_self.userBio.value);
                }

                if (_self.newPwd != ''){

                    if(_self.currentPwd.value == ''){
                        _self.currentPwd.hasError = true;
                        return false;
                    }else{
                        _self.currentPwd.hasError = false;
                        formData.append('currentPwd',_self.currentPwd.value);
                    }

                    if (_self.currentPwd.value == _self.newPwd.value){
                        _self.newPwd.hasError = true;
                        return false;
                    }

                    if (_self.newPwd.value != _self.newPwdConfirm.value){
                        _self.newPwdConfirm.hasError = true;
                        return false;
                    }else{
                        _self.newPwd.hasError = false;
                        _self.newPwdConfirm.hasError = false;
                        formData.append('newPwd',_self.newPwd.value);
                    }
                }
        	}
        }
    }
</script>