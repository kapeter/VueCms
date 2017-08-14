<template>
	<div>
		<page-heading title="角色管理" subTitle="Role Management" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
                    <ul class="block-button">
                        <li>
                            <a @click="createDialog()" class="btn btn-info"><i class="fa fa-plus"></i> 新增角色</a>
                        </li>
                    </ul>
	     		</div>

                <div class="block-content">
                    <div class="table-responsive">
                        <vuetable ref="vuetable"
                            :api-url="routeList.browseUrl"
                            :fields="fields"
                            @vuetable:pagination-data="onPaginationData">
                            <template slot="is_admin" scope="props">
                                <span v-if="props.rowData.is_admin != 1" class="label label-info">否</span>
                                <span v-else class="label label-success">是</span>
                            </template>
                            <template slot="actions" scope="props">
                                <div class="custom-actions" v-if="props.rowData.is_admin != 1">
                                   <button class="btn btn-sm btn-info" @click="itemAction('build-item', props.rowData)"><i class="fa fa-bars"></i> 配置</button>
                                    <button class="btn btn-sm btn-default" @click="itemAction('edit-item', props.rowData)"><i class="fa fa-pencil"></i> 编辑</button>
                                    <button class="btn btn-sm btn-danger" @click="itemAction('delete-item', props.rowData)"><i class="fa fa-times"></i> 删除</button>
                                </div>
                                <div v-else>超级管理员信息无法修改</div>
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

        <ElDialog :title="dialogTitle" v-model="dialogVisible">
            <form class="form-horizontal">
                <div class="form-group" :class="{ 'has-error' : errorInfo.name || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">唯一标识</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.name">唯一标识不能为空</div>
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">该角色已被存在</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.title  }">
                    <label for="name" class="col-sm-2 control-label">显示名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.title">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.title">显示名称不能为空</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">权限描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" v-model="formData.description" rows="5"></textarea>
                    </div>
                </div>
            </form>
          <span slot="footer">
            <button class="btn btn-default" @click="dialogVisible = false">取 消</button>
            <button class="btn btn-info" @click="submitRole()">确 定</button>
          </span>
        </ElDialog>

        <!-- 配置权限 -->
        <ElDialog :title="confDialogTitle" v-model="confDialogVisible">
            <form class="form-horizontal">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>系统模块</th>
                                <th class="text-center">浏览</th>
                                <th class="text-center">查看</th>
                                <th class="text-center">编辑</th>
                                <th class="text-center">删除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="permission in permissions">
                                <td>{{ permission.title }}</td>
                                <td class="text-center">
                                    <el-checkbox v-model="permission.can_create"></el-checkbox>
                                </td>
                                <td class="text-center">
                                    <el-checkbox v-model="permission.can_browser"></el-checkbox>
                                </td>
                                <td class="text-center">
                                    <el-checkbox v-model="permission.can_edit"></el-checkbox>
                                </td>
                                <td class="text-center">
                                    <el-checkbox v-model="permission.can_delete"></el-checkbox>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
          <span slot="footer">
            <button class="btn btn-default" @click="confDialogVisible = false">取 消</button>
            <button class="btn btn-info" @click="submitPermission()">确 定</button>
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
                    {to: null, text: '角色管理'},
                ],
                //API路由列表
                routeList: {
                    browseUrl : '/api/role',
                },
                fields: [
                    {
                      title: '显示名称',
                      name: 'title',
                    },
                    {
                      title: '唯一标识',
                      name: 'name',
                    },
                    {
                      title: '角色描述',
                      name: 'description',
                    },
                    {
                      title: '是否为超级管理员',
                      name: '__slot:is_admin',
                      titleClass: 'text-center',
                      dataClass: 'text-center'
                    },
                    {
                      title: '创建时间',
                      name: 'created_at',
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
		      	dialogVisible: false,
		      	dialogTitle: '新增角色',
                confDialogTitle: '',
                confDialogVisible: false,
		      	uniqueCheck: true,
		      	currentID: 0,
                formData: {
                	name: '',
                    title: '',
                    description: '',
                },
                errorInfo: {
                	name: false,
                    title: false,
                    description: false,
                },
                permissions: [],
			}
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
                this.dialogVisible = true;
            },
            freshDialog() {
                this.formData = {
                    name: '',
                    title: '',
                    description: '',
                };
                this.currentID = 0;
                this.clearError();
            },
	        itemAction (action, data) {
	        	let _self = this;
                switch(action){
                    case 'delete-item':
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
                        break;
                    case 'edit-item':
                        _self.formData = {
                            name: data.name,
                            title: data.title,
                            description: data.description,
                        };
                        _self.currentID = data.id;
                        _self.clearError();
                        _self.dialogTitle = '编辑角色';
                        _self.dialogVisible = true;                        
                        break;
                    case 'build-item':
                        _self.currentID = data.id;
                        _self.confDialogTitle = '编辑'+ data.title + '的权限';
                        _self.confDialogVisible = true;
                        axios.get(_self.routeList.browseUrl + '/' + data.id)
                            .then(function(res){
                                _self.permissions = res.data;
                            });

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
            //提交角色表单
            submitRole() {
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
                        	_self.dialogVisible = false;
                            sweetAlert.success();
                            _self.$refs.vuetable.refresh();
                        }
                    }) 
            },

            //提交配置权限表单
            submitPermission() {
                let _self = this;
                
            }

        }
	}
</script>

<style>
	.modal-content .block{
		margin-bottom: 0;
	}
</style>