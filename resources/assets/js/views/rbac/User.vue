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
						    :tfields="tfields"
						    :sort-order="sortOrder"
						    @vuetable:pagination-data="onPaginationData">
							<template slot="avatar" scope="props">
								<img class="img-avatar img-avatar32" :src="props.rowData.avatar">
						    </template>
							<template slot="role" scope="props">
                                <span class="label label-default" v-if="props.rowData.role == null">暂无角色</span>
								<span class="label label-success" v-else-if="props.rowData.role.is_admin == 1">{{ props.rowData.role.title }}</span>
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
                <div class="form-group" :class="{ 'has-error' : errors.has('email') || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">登录邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.email" name="email" v-validate="'required|email'">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('email')">
                            {{ errors.first('email') }}
                        </div>
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">该邮箱已被注册</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errors.has('name') }">
                    <label for="name" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name" name="name" v-validate="'required'" data-vv-as="用户名">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('name')">
                            {{ errors.first('name') }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">所属角色</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.auth" placeholder="请选择所属角色">
                            <el-option
                                v-for="role in roles"
                                :label="role.title"
                                :value="role.id" :key="role.id">
                            </el-option>
                        </el-select>                  
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errors.has('pwd')  }">
                    <label for="description" class="col-sm-2 control-label">登录密码</label>
                    <div class="col-sm-10 pwd-input">
						<input type="text" class="form-control" v-model="formData.pwd" name="pwd" v-validate="'required'">
						<button class="btn btn-sm btn-success" @click.prevent ="generatePwd()">生成密码</button>
                        <div class="help-block animated fadeInDown"  v-show="errors.has('pwd')">
                            {{ errors.first('pwd') }}
                        </div>
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
                <div class="form-group" :class="{ 'has-error' : errors.has('name') }">
                    <label for="name" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name" name="name" v-validate="'required'" data-vv-as="用户名">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('name')">
                            {{ errors.first('name') }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">所属角色</label>
                    <div class="col-sm-10" v-if="currentID != $store.state.theUser.id">
                        <el-select v-model="formData.auth" placeholder="请选择所属角色">
                            <el-option
                                v-for="role in roles"
                                :label="role.title"
                                :value="role.id" :key="role.id">
                            </el-option>
                        </el-select>                    
                    </div>
                    <div class="col-sm-10" v-else>
                        <label class="control-label">{{ $store.state.theUser.role.title }}</label>
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
	import ElDialog from '../../components/dialog'

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
                    browseUrl : 'user',
                    roleUrl: 'role'
                },
                roles: [],
		      	tfields: [
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
			          name: '__slot:role',
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
		        	{ tfield: 'created_at', sortField: 'created_at', direction: 'desc'}
		      	],
		      	createDialogVisible: false,
		      	editDialogVisible: false,
		      	uniqueCheck: true,
		      	currentID: 0,
                formData: {
                	email: '',
                    name: '',
                    auth: 1,
                    pwd: '',
                },
			}
		},
        created() {
            let _self = this;
            _self.$http.get(_self.routeList.roleUrl)
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
                this.formData = {
                    email: '',
                    name: '',
                    auth: 1,
                    pwd: '',
                };
                this.currentID = 0;
                this.uniqueCheck = true;
                this.errors.clear();
                this.createDialogVisible = true;
            },
            editDialog(data) {
                this.formData = {
                	email: data.email,
                    name: data.name,
                    auth: data.role.id,
                };
                this.currentID = data.id;
                this.uniqueCheck = true;
                this.errors.clear();
                this.editDialogVisible = true;
            },
	        itemAction (action, data) {
	        	let _self = this;
	            if (action == 'delete-item'){
                    _self.$message.delete(function(){
                        let deleteUrl = _self.routeList.browseUrl + '/' + data.id;
                        _self.$http.delete(deleteUrl)
                            .then(function(response){
                                if (response.status == 200){
                                    _self.$message.success();
                                    _self.$refs.vuetable.refresh();
                                }
                            })
                            .catch(function (error) {
                                _self.$message.error();
                            });
                    })                 
	            }else{
                    _self.$http.get(_self.routeList.browseUrl + '/' + data.id)
                        .then(function (res) {
                            _self.editDialog(res.data.data);
                        })
                        .catch(function (error) {
                            _self.$message.error();
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
            //提交表单
            submitUser() {
                let _self = this;
                _self.$validator.validateAll().then((result) => {
                    if (result) {
                        let apiUrl = _self.routeList.browseUrl;
                        _self.uniqueCheck = true;

                        if (_self.currentID != 0){
                            apiUrl += '/' + _self.currentID;
                            _self.formData['_method'] = 'PUT';
                        }
                        _self.$http.post(apiUrl, _self.formData)
                            .then(function (res) {
                                if (res.data.code && res.data.code == 10009){
                                    _self.uniqueCheck = false;
                                }else{
                                    _self.createDialogVisible = false;
                                    _self.editDialogVisible = false;
                                    _self.$message.success();
                                    _self.$refs.vuetable.refresh();
                                }
                            });
                    }
                });
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