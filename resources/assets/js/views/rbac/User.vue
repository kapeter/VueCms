<template>
	<div>
		<page-heading title="用户管理" subTitle="User Management" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
                    <ul class="block-button">
                        <li>
                            <a @click="createDialog()" class="btn btn-info"><i class="fa fa-plus"></i> 新增用户</a>
                        </li>
                    </ul>
	     		</div>

	     		<div class="block-content">
	     			<div class="table-responsive">
						<vuetable ref="vuetable"
						    :api-url="routeList.browseUrl"
						    :fields="fields"
						    :sort-order="sortOrder"
						    @vuetable:pagination-data="onPaginationData">
							<template slot="avatar" scope="props">
								<img class="img-avatar img-avatar32" :src="props.rowData.avatar">
						    </template>
							<template slot="authShow" scope="props">
								<span class="label label-success" v-if="props.rowData.role.is_admin == 1">{{ props.rowData.role.title }}</span>
								<span class="label label-info" v-else>{{ props.rowData.role.title }}</span>
						    </template>
							<template slot="actions" scope="props">
						    	<div class="custom-actions">
		        					<button class="btn btn-sm btn-default" @click="itemAction('edit-item', props.rowData)"><i class="fa fa-pencil"></i> 编辑</button>
		        					<button class="btn btn-sm btn-danger" @click="itemAction('delete-item', props.rowData)"><i class="fa fa-times"></i> 删除</button>
						    	</div>
						    </template>
						</vuetable> 
					</div>
					<div class="row">
						<div class="col-sm-6 pagination-info">
							<vuetable-pagination-info ref="paginationInfo" info-class="pagination-info"></vuetable-pagination-info>
						</div>
						<div class="col-sm-6">
							<vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
						</div>
					</div>
			    </div>  		
	     	</div>   
        </div>
        <!-- END Page Content -->
        <ElDialog title="新增用户" v-model="createDialogVisible">
            <form class="form-horizontal">
                <div class="form-group" :class="{ 'has-error' : errorInfo.email || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">登录邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.email">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.email">邮箱不能为空</div>
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">该邮箱已被注册</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.name  }">
                    <label for="name" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.name">用户名不能为空</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.auth  }">
                    <label for="model" class="col-sm-2 control-label">所属角色</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.auth" placeholder="请选择所属角色">
                            <el-option
                                v-for="role in roles"
                                :label="role.title"
                                :value="role.id" :key="role.id">
                            </el-option>
                        </el-select> 
                        <div class="help-block animated fadeInDown" v-show="errorInfo.auth">请选择所属角色</div>                   
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.pwd  }">
                    <label for="description" class="col-sm-2 control-label">登录密码</label>
                    <div class="col-sm-10 pwd-input">
						<input type="text" class="form-control" v-model="formData.pwd">
						<button class="btn btn-sm btn-success" @click.prevent ="generatePwd()">生成密码</button>
						<div class="help-block animated fadeInDown" v-show="errorInfo.pwd">密码不能为空</div>
                    </div>
                </div>
            </form>
            <span slot="footer">
                <button class="btn btn-default" @click="createDialogVisible = false">取 消</button>
                <button class="btn btn-info" @click="submitUser()">确 定</button>
            </span>
        </ElDialog>

		<!-- 编辑用户信息 -->
        <ElDialog title="编辑用户信息" v-model="editDialogVisible">
            <form class="form-horizontal">
            	<input type="hidden" name="id" v-model="currentID">
                <div class="form-group">
                    <label for="slug" class="col-sm-2 control-label">登录邮箱</label>
                    <div class="col-sm-10">
                    	<label class="control-label">{{ formData.email }}</label>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.name  }">
                    <label for="name" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.name">用户名不能为空</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.auth  }">
                    <label for="model" class="col-sm-2 control-label">所属角色</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.auth" placeholder="请选择所属角色">
                            <el-option
                                v-for="role in roles"
                                :label="role.title"
                                :value="role.id" :key="role.id">
                            </el-option>
                        </el-select> 
                        <div class="help-block animated fadeInDown" v-show="errorInfo.auth">请选择所属角色</div>                   
                    </div>
                </div>
            </form>
          	<span slot="footer">
            	<button class="btn btn-default" @click="editDialogVisible = false">取 消</button>
            	<button class="btn btn-info" @click="submitUser()">确 定</button>
          	</span>
        </ElDialog>
	</div>
</template>

<script>
	import ElDialog from '../../packages/dialog'

	export default {
    	props: {
	        rowData: {
	            type: Object,
	        },
	        rowIndex: {
	            type: Number
	        }
	    },
        components: {
            ElDialog,
        },
		data() {
			return {
				crumbs: [
                    {to: null, text: '用户管理'},
                ],
                //API路由列表
                routeList: {
                    browseUrl : '/api/user',
                    roleUrl: '/api/role'
                },
                roles: [],
		      	fields: [
			        {
			          title: '头像',
			          name: '__slot:avatar',
			          titleClass: 'text-center',
			          dataClass: 'text-center'  
			        },
			        {
			          title: '用户名',
			          name: 'name',
			          sortField: 'name',
			        },
			        {
			          title: '邮箱',
			          name: 'email',
			        },
			        {
			          title: '角色',
			          name: '__slot:authShow',
                      titleClass: 'text-center',
                      dataClass: 'text-center',
			        },
			        {
			          title: '创建时间',
			          name: 'created_at',
			          sortField: 'updated_at',
			          titleClass: 'text-center',
			          dataClass: 'text-center',
			          callback: 'dateFormat'
			        },
			        {
			          name: '__slot:actions',
			          title: '操作',
			          titleClass: 'text-center',
			          dataClass: 'text-center'
			        }
		      	],
		      	sortOrder: [
		        	{ field: 'created_at', sortField: 'created_at', direction: 'desc'}
		      	],
		      	createDialogVisible: false,
		      	editDialogVisible: false,
		      	uniqueCheck: true,
		      	currentID: 0,
                formData: {
                	email: '',
                    name: '',
                    auth: '',
                    pwd: '',
                },
                errorInfo: {
                	email: false,
                    name: false,
                    auth: false,
                    pwd: false,
                },

			}
		},
        created() {
            let _self = this;
            axios.get(_self.routeList.roleUrl)
                .then(function (res) {
                    _self.roles = res.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
        	dateFormat (value) {
        		return (value == null) ? '' : value.date.substring(0,10);
        	},
		    onPaginationData (paginationData) {
		      	this.$refs.pagination.setPaginationData(paginationData);
		      	this.$refs.paginationInfo.setPaginationData(paginationData);
		    },
		    onChangePage (page) {
		      	this.$refs.vuetable.changePage(page)
		    },
		    deleteSuccess() {
		    	Vue.nextTick( () => this.$refs.vuetable.refresh() )
		    },
            createDialog() {
                this.freshDialog();
                this.createDialogVisible = true;
            },
            editDialog(data) {
                this.formData = {
                	email: data.email,
                    name: data.name,
                    auth: data.role.id,
                };
                this.currentID = data.id;
                this.editDialogVisible = true;
            },
            freshDialog() {
                this.formData = {
                	email: '',
                    name: '',
                    auth: '',
                    pwd: '',
                };
                this.currentID = 0;
            },
	        itemAction (action, data) {
	        	let _self = this;
	            if (action == 'delete-item'){
	                sweetAlert({
	                    title: "危险操作",
	                    text: "您确认删除该项信息吗？",
	                    type: "warning",
	                    showCancelButton: true,
	                    confirmButtonColor: "#d26a5c",
	                    confirmButtonText: "删  除",
	                    cancelButtonText: "取  消",
	                    closeOnConfirm: false,
	                    showLoaderOnConfirm: true,
	                },
	                function(isConfirm){
	                    if (isConfirm){
	                        let deleteUrl = _self.routeList.browseUrl + '/' + data.id;
	                        axios.delete(deleteUrl)
	                            .then(function(response){
	                            	if (response.status == 200){
										sweetAlert.success();
		                                _self.$refs.vuetable.refresh();
	                            	}
	                            })
	                            .catch(function (error) {
	                            	sweetAlert.error();
								});
	                    }
	                });                
	            }else{
                    axios.get(_self.routeList.browseUrl + '/' + data.id)
                        .then(function (res) {
                            _self.editDialog(res.data.data);
                        })
                        .catch(function (error) {
                            sweetAlert.error();
                        })
	            }
	        },
            //生成密码
            generatePwd() {
			  let iteration = 0;
			  let password = "";
			  let randomNumber;
			  while (iteration < 12) {
			    randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
			    if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
      			if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
      			if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
      			if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
			    iteration++;
			    password += String.fromCharCode(randomNumber);
			  }

			  this.formData.pwd = password;
            },
            clearError() {
                for (let x in this.errorInfo){
                    this.errorInfo[x] = false;
                }
                this.uniqueCheck = true;
            },
            //表单数据检查
            checkData() {
                let value = this.formData;
                for (let x in value){
                    if (value[x] === ''){
                        this.errorInfo[x] = true;
                        return false;
                    }
                }
                return true;
            },
            //提交表单
            submitUser() {
                let _self = this;
                let apiUrl = _self.routeList.browseUrl;
                _self.clearError();

                if (!_self.checkData()){
                    return false;
                }

                if (_self.currentID != 0){
                    apiUrl += '/' + _self.currentID;
                    _self.formData['_method'] = 'PUT';
                }
                axios.post(apiUrl,_self.formData)
                    .then(function (res) {
                        if (res.data.code && res.data.code == 10009){
                            _self.uniqueCheck = false;
                        }else{
                        	if (_self.currentID != 0){
                        		_self.editDialogVisible = false;
                        	}else{
                        		_self.createDialogVisible = false;
                        	}
                            sweetAlert.success();
                            _self.$refs.vuetable.refresh();
                        }
                    }) 
            },
        }
	}
</script>

<style>
	.el-radio-group{
		line-height: 34px;
	}
	.modal-content .block{
		margin-bottom: 0;
	}
	.el-select{
		display: block;
	}
	.el-select-dropdown{
		z-index: 3000!important;
	}
	.pwd-input .form-control{
		display: inline-block;
		width: auto;
		min-width: 200px;
		margin-right: 5px;
	}
	.pwd-input .btn-sm{
		padding: 6px 10px;
	}
</style>