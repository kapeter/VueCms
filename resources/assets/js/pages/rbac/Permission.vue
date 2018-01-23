<template>
	<div>
		<page-heading title="权限管理" subTitle="Property Management" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
	     	<div class="block">
	     		<div class="block-header remove-padding-b">
                    <ul class="block-button">
                        <li>
                            <a @click="createDialog()" class="btn btn-info"><i class="fa fa-plus"></i> 新增权限</a>
                        </li>
                    </ul>
	     		</div>

                <div class="block-content">
                    <div class="table-responsive">
                        <vuetable ref="vuetable"
                            :api-url="routeList.browseUrl"
                            :tfields="tfields"
                            @vuetable:pagination-data="onPaginationData">
                            <template slot="title" slot-scope="props">
                                <i :class="'fa fa-' + props.rowData.icon + ' push-5-r'"></i>
                                {{ props.rowData.title }}
                            </template>
                            <template slot="actions" slot-scope="props">
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

        <ElDialog :title="dialogTitle" :visible.sync="dialogVisible" width="36%">
            <form>
                <div class="form-group" :class="{ 'has-error' : errors.has('route') || !uniqueCheck }">
                    <label for="slug">唯一路由</label>
                    <input type="text" class="form-control" v-model="formData.route" name="route" v-validate="'required|alpha'">
                    <div class="help-block animated fadeInDown" v-show="!uniqueCheck">该路由已被存在</div>
                    <div class="help-block animated fadeInDown"  v-show="errors.has('route')">
                        {{ errors.first('route') }}
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' :  errors.has('title')  }">
                    <label for="name">显示名称</label>
                    <input type="text" class="form-control" v-model="formData.title" name="title" v-validate="'required'">
                    <div class="help-block animated fadeInDown"  v-show="errors.has('title')">
                        {{ errors.first('title') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">权限描述</label>
                    <textarea class="form-control" v-model="formData.description" rows="5"></textarea>
                </div>
                <div class="form-group" :class="{ 'has-error' :  errors.has('icon')  }">
                    <label for="name">
                        菜单图标
                        <span class="font-s13">
                            （<i class="fa fa-info"></i> 本站使用 <a href="http://fontawesome.io/icons/">FontAwesome</a> 图标驱动，填写时请去除前缀fa-，例如：file）
                        </span>
                    </label>
                    <input type="text" class="form-control" v-model="formData.icon" name="icon" v-validate="'required'">
                    <div class="help-block animated fadeInDown"  v-show="errors.has('icon')">
                        {{ errors.first('icon') }}
                    </div>
                </div>
            </form>
          <span slot="footer">
            <button class="btn btn-default" @click="dialogVisible = false">取 消</button>
            <button class="btn btn-info" @click="submitUser()">确 定</button>
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
                    {to: null, text: '权限管理'},
                ],
                //API路由列表
                routeList: {
                    browseUrl : 'permission',
                },
                tfields: [
                    {
                      name: '__slot:title',
                      title: '显示名称',
                    },
                    {
                      title: '唯一路由',
                      name: 'route',
                    },
                    {
                      title: '权限描述',
                      name: 'description',
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
		      	dialogTitle: '新增权限',
		      	uniqueCheck: true,
		      	currentID: 0,
                formData: {
                	route: '',
                    title: '',
                    description: '',
                    icon: ''
                },
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
                    route: '',
                    title: '',
                    description: '',
                    icon: ''
                };
                this.currentID = 0;
                this.uniqueCheck = true;
                this.errors.clear();
                this.dialogTitle = '新增权限';
                this.dialogVisible = true;
            },
            editDialog(data) {
                this.formData = {
                	route: data.route,
                    title: data.title,
                    description: data.description,
                    icon: data.icon
                };
                this.currentID = data.id;
                this.uniqueCheck = true;
                this.errors.clear();
                this.dialogTitle = '编辑权限';
                this.dialogVisible = true;
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
                    _self.editDialog(data);
	            }
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
                        _self.$http.post(apiUrl,_self.formData)
                            .then(function (res) {
                                if (res.data.code && res.data.code == 10009){
                                    _self.uniqueCheck = false;
                                }else{
                                    _self.dialogVisible = false;
                                    _self.$message.success();
                                    _self.$refs.vuetable.refresh();
                                }
                            })
                            .catch(function(err){
                                _self.$message.error();
                            });
                    }
                });
            },
        }
	}
</script>

<style>
	.modal-content .block{
		margin-bottom: 0;
	}
</style>