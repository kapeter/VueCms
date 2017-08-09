<template>
	<div>
		<page-heading title="权限管理" subTitle="Property Management" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
                    <ul class="block-button">
                        <li>
                            <a @click="createDialog()" class="btn btn-info"><i class="fa fa-plus"></i> 新增权限</a>
                        </li>
                    </ul>
	     		</div>

	     		<div class="block-content">
	     			<div class="table-responsive">
                        <table class="js-table-sections table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:30px;"></th>
                                    <th>显示名称</th>
                                    <th>路由</th>
                                    <th class="text-center">权限类型</th>
                                    <th>描述</th>
                                    <th class="text-center">是否为菜单</th>
                                    <th class="text-center">操作</th>
                                </tr>
                            </thead>
                            <tbody class="js-table-sections-header" v-for="field in fields">
                                <tr>
                                    <td class="text-center">
                                        <i class="fa fa-angle-right"></i>
                                    </td>
                                    <td class="font-w600">{{ field.title }}</td>
                                    <td>{{ field.url }}</td>
                                    <td class="text-center">{{ field.type }}</td>
                                    <td>{{ field.description }}</td>
                                    <td class="text-center">
                                        <span v-if="field.is_menu == 1" class="label label-success">是</span>
                                        <span v-else class="label label-danger">否</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-default" @click="itemAction('edit-item', field)"><i class="fa fa-pencil"></i> 编辑</button>
                                        <button class="btn btn-sm btn-danger" @click="itemAction('delete-item', field)"><i class="fa fa-times"></i> 删除</button>        
                                    </td>
                                </tr>
                            </tbody>                                
                        </table>
					</div>
			    </div>  		
	     	</div>   
        </div>
	</div>
</template>

<script>
	import ElDialog from '../../packages/dialog'

	export default {
        components: {
            ElDialog,
        },
		data() {
			return {
				crumbs: [
                    {to: null, text: '权限管理'},
                ],
                fields:[],
                //API路由列表
                routeList: {
                    browseUrl    : '/api/permission',
                },
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
        mounted() {
            let _self = this;
            axios.get(_self.routeList.browseUrl)
                .then(function (res) {
                    _self.fields = res.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
        	dateFormat (value) {
        		return (value == null) ? '' : value.date.substring(0,10);
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
                    auth: data.is_admin,
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
	                        let deleteUrl = '/api/user/' + data.id;
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
                    axios.get('/api/user/' + data.id)
                        .then(function (res) {
                            _self.editDialog(res.data.data);
                        })
                        .catch(function (error) {
                            sweetAlert.error();
                        })
	            }
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
                let apiUrl = '/api/user';
                _self.clearError();

                if (!_self.checkData()){
                    return false;
                }

                if (_self.currentID != 0){
                    apiUrl = '/api/user/' + _self.currentID;
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