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
                        <vuetable ref="vuetable"
                            :api-url="routeList.browseUrl"
                            :tfields="tfields"
                            @vuetable:pagination-data="onPaginationData">
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

        <ElDialog :title="dialogTitle" v-model="dialogVisible">
            <form class="form-horizontal">
                <div class="form-group" :class="{ 'has-error' : errors.has('route') || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">唯一路由</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.route" name="route" v-validate="'required'">
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">该路由已被存在</div>
                        <div class="help-block animated fadeInDown"  v-show="errors.has('route')">
                            {{ errors.first('route') }}
                        </div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' :  errors.has('title')  }">
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
                    {to: null, text: '权限管理'},
                ],
                //API路由列表
                routeList: {
                    browseUrl : '/api/permission',
                },
                tfields: [
                    {
                      title: '显示名称',
                      name: 'title',
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
                this.freshDialog();
                this.dialogVisible = true;
            },
            editDialog(data) {
                this.formData = {
                	route: data.route,
                    title: data.title,
                    description: data.description,
                };
                this.currentID = data.id;
                this.uniqueCheck = true;
                this.dialogTitle = '编辑权限';
                this.dialogVisible = true;
            },
            freshDialog() {
                this.formData = {
                    route: '',
                    title: '',
                    description: '',
                };
                this.currentID = 0;
                this.uniqueCheck = true;
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
                        axios.post(apiUrl,_self.formData)
                            .then(function (res) {
                                if (res.data.code && res.data.code == 10009){
                                    _self.uniqueCheck = false;
                                }else{
                                    _self.dialogVisible = false;
                                    sweetAlert.success();
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
	.modal-content .block{
		margin-bottom: 0;
	}
</style>