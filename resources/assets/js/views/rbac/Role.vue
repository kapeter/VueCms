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
                            :tfields="tfields"
                            @vuetable:pagination-data="onPaginationData">
                            <template slot="is_admin" slot-scope="props">
                                <span v-if="props.rowData.is_admin != 1" class="label label-info">否</span>
                                <span v-else class="label label-success">是</span>
                            </template>
                            <template slot="actions" slot-scope="props">
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

        <ElDialog :title="dialogTitle" :visible.sync="dialogVisible" width="36%">
            <form class="form-horizontal">
                <div class="form-group" :class="{ 'has-error' : errors.has('name') || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">唯一标识</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name" name="name" v-validate="'required|alpha_num'" data-vv-as="唯一标识">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('name')">
                            {{ errors.first('name') }}
                        </div>
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">该角色已被存在</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errors.has('title')  }">
                    <label for="name" class="col-sm-2 control-label">显示名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.title" name="title" v-validate="'required'">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('title')">
                            {{ errors.first('title') }}
                        </div>
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
        <ElDialog :title="confDialogTitle" :visible.sync="confDialogVisible" width="36%">
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
	export default {
        props: {
            rowData: {
                type: Object,
            },
            rowIndex: {
                type: Number
            }
        },
		data() {
			return {
				crumbs: [
                    {to: null, text: '角色管理'},
                ],
                //API路由列表
                routeList: {
                    browseUrl : 'role',
                },
                tfields: [
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
                      title: '是否为管理员',
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
                this.formData = {
                    name: '',
                    title: '',
                    description: '',
                };
                this.currentID = 0;
                this.uniqueCheck = true;
                this.errors.clear();
                this.dialogTitle = '新增角色';
                this.dialogVisible = true;
            },
            editDialog(data) {
                this.formData = {
                    name: data.name,
                    title: data.title,
                    description: data.description,
                };
                this.currentID = data.id;
                this.uniqueCheck = true;
                this.errors.clear();
                this.dialogTitle = '编辑角色';
                this.dialogVisible = true;
            },
	        itemAction (action, data) {
	        	let _self = this;
                switch(action){
                    case 'delete-item':
                        _self.$message.delete(function(){
                            let deleteUrl = _self.routeList.browseUrl + '/' + data.id;
                            _self.$http.delete(deleteUrl)
                                .then(function(res){
                                    if (res.data.code && res.data.code == 10011){
                                        _self.$message.error(res.data.message);
                                    }else{
                                        _self.$message.success();
                                        _self.$refs.vuetable.refresh();
                                    }
                                })
                                .catch(function (error) {
                                    _self.$message.error();
                                });
                        }) 
                        break;
                    case 'edit-item':
                        _self.editDialog(data);                        
                        break;
                    case 'build-item':
                        _self.$http.get(_self.routeList.browseUrl + '/' + data.id)
                            .then(function(res){
                                _self.permissions = res.data;
                                for (var i = _self.permissions.length - 1; i >= 0; i--) {
                                    _self.permissions[i].can_browser = _self.permissions[i].can_browser ? true : false;
                                    _self.permissions[i].can_create = _self.permissions[i].can_create ? true : false;
                                    _self.permissions[i].can_edit = _self.permissions[i].can_edit ? true : false;
                                    _self.permissions[i].can_delete = _self.permissions[i].can_delete ? true : false;
                                }
                                _self.currentID = data.id;
                                _self.confDialogTitle = '编辑'+ data.title + '的权限';
                                _self.confDialogVisible = true;
                            })
                            .catch(function(){
                                _self.$message.error();
                            });

                }
	        },
            //提交角色表单
            submitRole() {
                let _self = this;
                _self.$validator.validateAll().then((result) => {
                    if (result) {
                        let apiUrl = _self.routeList.browseUrl;
                        _self.uniqueCheck = true;

                        if (_self.currentID != 0){
                            apiUrl += '/' + _self.currentID;
                            _self.formData['_method'] = 'PUT';
                        }
                        _self.$http.post(apiUrl,_self.formData)
                            .then(function (res) {
                                if (res.data.code && res.data.code == 10009){
                                    _self.uniqueCheck = false;
                                }else{
                                    _self.dialogVisible = false;
                                    _self.$message.success();
                                    _self.$refs.vuetable.refresh();
                                }
                            });
                    }
                });
            },

            //提交配置权限表单
            submitPermission() {
                let _self = this;
                let apiUrl = _self.routeList.browseUrl + '/build/' + _self.currentID;
                _self.$http.post(apiUrl,_self.permissions)
                    .then(function(res){
                        _self.confDialogVisible = false;
                        _self.$message.success();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            }

        }
	}
</script>

<style>
	.modal-content .block{
		margin-bottom: 0;
	}
</style>