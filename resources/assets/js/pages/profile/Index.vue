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
                    <h2 class="h3 font-w600 text-white push-5" style="text-transform:uppercase;">{{ thisUser.name }}</h2>
                    <h3 class="h5 text-white">{{ 'role' in thisUser ? thisUser.role.title : '' }}</h3>
                    <p class="push-10-t text-white-op">账户于{{ dateInfo.createTime }}创建，已运行{{ dateInfo.duration }}天。</p>
                </div>
            </div>
            <!-- END Basic Info -->

        </div>
        <!-- END User Header -->

        <!-- Main Content -->
        <div class="block">
            <form>
                <el-tabs v-model="tabActiveName">
                    <el-tab-pane label="个人设置" name="personal">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group">
                                    <label>邮箱地址</label>
                                    <div class="form-control-static font-w700">{{ thisUser.email }}</div>
                                </div>
                                <div class="form-group" :class="{ 'has-error' : userName.hasError  }">
                                        <label for="profile-email">用户名</label>
                                        <input class="form-control" type="text" id="profile-email" name="profile-email" v-model="userName.value">
                                        <div class="help-block animated fadeInDown" v-show="userName.hasError">用户名不能为空。</div>
                                </div>
                                <div class="form-group">
                                    <label for="profile-bio">个人签名</label>
                                    <textarea class="form-control" id="profile-bio" name="profile-bio" rows="10" v-model="userBio.value">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="密码设置" name="password">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group" :class="{ 'has-error' : currentPwd.hasError  }">
                                    <label for="profile-password">当前密码</label>
                                    <input class="form-control" type="password" v-model="currentPwd.value">
                                    <div class="help-block animated fadeInDown" v-show="currentPwd.hasError">{{ currentPwd.errorText }}</div>
                                </div>
                                <hr>
                                <div class="form-group" :class="{ 'has-error' : newPwd.hasError  }">
                                    <label for="profile-password-new">新的密码</label>
                                    <input class="form-control" type="password" v-model="newPwd.value">
                                    <div class="help-block animated fadeInDown" v-show="newPwd.hasError">新密码不能与当前密码一致</div>
                                </div>
                                <div class="form-group" :class="{ 'has-error' : newPwdConfirm.hasError  }">
                                    <label for="profile-password-new-confirm">重复新的密码</label>
                                    <input class="form-control" type="password" v-model="newPwdConfirm.value">
                                    <div class="help-block animated fadeInDown" v-show="newPwdConfirm.hasError">两次输入的密码不一致</div>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="头像修改" name="avatar">
                        <div class="row">
                        </div>
                    </el-tab-pane>
                </el-tabs>
                <div class="block-content block-content-full text-center">
                    <button class="btn btn-info" type="submit" @click.prevent="submitData()"><i class="fa fa-check push-5-r"></i> 保存设置 </button>
                    <button class="btn btn-warning" @click.prevent="resetData()"><i class="fa fa-refresh push-5-r"></i> 重置表单 </button>
                </div>
            </form>
        </div>
        <!-- END Main Content -->
    </div>
    <!-- END Page Content -->
</template>

<script>
    export default {
        data() {
            return {
                tabActiveName: 'personal',
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
                    errorText: '',
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
            dateInfo() {
                let createTime = 0;
                let duration = 0;
                if ('created_at' in this.thisUser){
                    createTime = this.thisUser.created_at.date.substring(0,10);
                    let interval = Date.parse(new Date()) - Date.parse(new Date(createTime));
                    duration = Math.ceil(interval / (1000 * 60 * 60 * 24));                    
                }
                return {
                    createTime: createTime,
                    duration: duration
                }
            }
        },
        mounted() {
            this.resetData();
        },
        methods: {
        	resetData() {
                this.thisUser = this.$store.state.theUser;
                this.userName.value = this.thisUser.name;
                this.userBio.value = this.thisUser.bio;
                this.clearError();
                this.clearInput();
        	},
        	submitData() {
        		let formData = new FormData();
                let _self = this;

                if ( _self.validateData() ){

                    _self.clearError();

                    formData.append('name',_self.userName.value); 
                    formData.append('bio',_self.userBio.value);
                    if(_self.newPwd.value != ''){
                        formData.append('currentPwd',_self.currentPwd.value);
                        formData.append('newPwd',_self.newPwd.value);                        
                    }

                    _self.$http.post('profile',formData)
                        .then(function(res){
                            if (res.data.code && res.data.code == 10002){
                                _self.currentPwd.hasError = true;
                                _self.currentPwd.errorText = res.data.message;
                            }else{
                                _self.$message.success();
                                _self.$store.commit('setUserInfo', res.data);
                                _self.resetData();
                            }
                        })
                        .catch(function (err) {
                            _self.$message.error();
                        })
                }
        	},
            validateData() {
                if (this.userName.value == ''){
                     this.userName.hasError = true;
                    return false;
                }

                if (this.newPwd.value != ''){
                    if(this.currentPwd.value == ''){
                        this.currentPwd.hasError = true;
                        this.currentPwd.errorText = "当前密码不能为空";
                        return false;
                    }
                    if (this.currentPwd.value == this.newPwd.value){
                        this.newPwd.hasError = true;
                        return false;
                    }
                    if (this.newPwd.value != this.newPwdConfirm.value){
                        this.newPwdConfirm.hasError = true;
                        return false;
                    }
                }
                return true;
            },
            clearError() {
                this.userName.hasError = false;
                this.newPwd.hasError = false;
                this.newPwdConfirm.hasError = false;
                this.userBio.hasError = false;
                this.currentPwd.hasError = false;
            },
            clearInput() {
                this.newPwd.value = '';
                this.newPwdConfirm.value = '';
                this.currentPwd.value = '';
            }
        }
    }
</script>

<style>
    .el-tabs__nav{
        width: 100%;
    }
    .el-tabs__header{
        margin: 0 0 30px;
    }
    .el-tabs__item{
        width: 33.3%;
        text-align: center;
        font-weight: bold;
        height: auto;
        line-height: 1;
        padding: 20px;
        font-size: 15px;
    }
</style>