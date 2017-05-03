<template>
	<div>
        <page-heading title="分类目录" subTitle="All Categories" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
            <!-- Frequently Asked Questions -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <ul class="block-options block-options-left">
                        <li>
                            <a @click="createDialog()"><i class="fa fa-plus"></i> 新增目录</a>
                        </li>
                    </ul>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <vuetable ref="vuetable"
                            api-url="/api/category"
                            :fields="fields"
                            :css="css.table"
                            @vuetable:pagination-data="onPaginationData"
                            :append-params="moreParams">
                            <template slot="devideName" scope="props">
                                <h4 class="h5 text-info">{{ props.rowData.name }}</h4>
                                <span class="font-s13 text-muted">/ {{ props.rowData.slug }}</span>
                            </template>
                            <template slot="recentLink" scope="props">
                                <span v-if="props.rowData.detail.count == 0">无</span>
                                <span v-else>
                                    <a @click="turnToEdit(props.rowData.detail.model, props.rowData.detail.article.id)" href="javascript:;">
                                        {{ props.rowData.detail.article.title }}
                                    </a>
                                    <br>
                                    <em class="font-s13 text-muted">updated {{ props.rowData.detail.article.updated_at }}</em>
                                </span>
                            </template>
                            <template slot="actions" scope="props">
                                <div class="custom-actions">
                                    <button class="btn btn-sm btn-default" @click="itemAction('edit-item', props.rowData)"><i class="fa fa-pencil"></i> 编辑</button>
                                    <button class="btn btn-sm btn-danger" @click="itemAction('delete-item', props.rowData)"><i class="fa fa-times"></i> 删除</button>
                                </div>
                            </template>
                        </vuetable> 
                        <nav class="text-right">
                            <vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- END Frequently Asked Questions -->
        </div>
        <!-- END Page Content -->

        <!-- Create Model -->
        <ElDialog :title="modalTitle" v-model="dialogVisible" size="tiny">
            <form class="form-horizontal">
                <input type="hidden" name="id" v-model="currentID">
                <div class="form-group" :class="{ 'has-error' : errorInfo.name  }">
                    <label for="name" class="col-sm-2 control-label">目录名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.name">目录名称不能为空</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.slug || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">唯一标识</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.slug" placeholder="仅支持英文、数字">
                        <div class="help-block animated fadeInDown" v-show="errorInfo.slug">唯一标识不能为空</div>
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">唯一标识重复</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.model  }">
                    <label for="model" class="col-sm-2 control-label">所属模型</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.model" placeholder="请选择模型">
                            <el-option
                                v-for="item in models"
                                :label="item.label"
                                :value="item.value" :key="item.value">
                            </el-option>
                      </el-select>
                      <div class="help-block animated fadeInDown" v-show="errorInfo.model">请选择所属模型</div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errorInfo.description  }">
                    <label for="description" class="col-sm-2 control-label">目录描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" v-model="formData.description" rows="3"></textarea>
                        <div class="help-block animated fadeInDown" v-show="errorInfo.description">目录描述不能为空</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="parent" class="col-sm-2 control-label">父级目录</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.parent_id" placeholder="请选择父级目录">
                            <el-option label="无" :value="0"></el-option>
                            <el-option
                              v-for="parent in parentCategory"
                              :label="parent.name"
                              :value="parent.id" :key="parent.slug">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </form>
          <span slot="footer">
            <button class="btn btn-default" @click="dialogVisible = false">取 消</button>
            <button class="btn btn-primary" @click="submitCategory()">确 定</button>
          </span>
        </ElDialog>
        <!-- END Create Model-->
	</div>
</template>

<script>
    import ElDialog from '../../../packages/dialog'
    import models from '../../../config/models.js'

    export default {
        components: {
            ElDialog,
        },
        data () {
            return {
                models: models,
                parentCategory: [],
                dialogVisible: false,
                crumbs: [
                    {to: null, text: '分类目录'},
                ],
                formData: {
                    name: '',
                    slug: '',
                    model: '',
                    description: '',
                    parent_id: 0
                },
                errorInfo: {
                    name: false,
                    model: false,
                    description: false,
                    slug: false,
                },
                uniqueCheck: true,
                modalTitle: '新增目录',
                currentID: 0,
                fields: [
                    {
                      title: '名称  /  唯一标识',
                      name: '__slot:devideName',
                    },
                    {
                      title: '模型',
                      name: 'model',
                      titleClass: 'text-center',
                      dataClass: 'text-center',
                    },
                    {
                      title: '描述',
                      name: 'description',
                    },
                    {
                      name: 'detail.count',
                      title: '发表数',
                      titleClass: 'text-center',
                      dataClass: 'text-center',
                    },
                    {
                      name: '__slot:recentLink',   
                      title: '最新发表',
                    },
                    {
                      name: '__slot:actions',
                      title: '操作',
                      titleClass: 'text-center',
                      dataClass: 'text-center'
                    }
                ],
                css: {
                    table: {
                      tableClass: 'table table-striped table-borderless table-vcenter',
                    },
                },
                moreParams: {},
            }
        },
        mounted() {
            let _self = this;
            axios.get('/api/category')
                .then(function (res) {
                    _self.parentCategory = res.data.data;
                })
        },
        methods: {
            createDialog() {
                this.freshDialog();
                this.modalTitle = '新增目录';
                this.dialogVisible = true;
            },
            editDialog(data) {
                this.formData = {
                    name: data.name,
                    slug: data.slug,
                    model: data.model,
                    description: data.description,
                    parent_id: data.parent_id
                };
                this.currentID = data.id;
                this.modalTitle = '修改目录';
                this.dialogVisible = true;
            },
            freshDialog() {
                this.formData = {
                    name: '',
                    slug: '',
                    model: '',
                    description: '',
                    parent_id: 0
                };
                this.currentID = 0;
            },
            checkData() {
                let value = this.formData;
                for (let x in value){
                    if (value[x] == '' && x != 'parent_id'){
                        this.errorInfo[x] = true;
                        return false;
                    }
                }
                return true;
            },
            clearError() {
                for (let x in this.errorInfo){
                    this.errorInfo[x] = false;
                }
                this.uniqueCheck = true;
            },
            submitCategory() {
                let _self = this;
                let apiUrl = '/api/category';
                _self.clearError();

                if (!_self.checkData()){
                    return false;
                }

                if (_self.currentID != 0){
                    apiUrl = '/api/category/' + _self.currentID;
                    _self.formData['_method'] = 'PUT';
                }
                axios.post(apiUrl,_self.formData)
                    .then(function (res) {
                        console.log(res);
                        if (res.data.code && res.data.code == 10001){
                            _self.uniqueCheck = false;
                        }else{
                            _self.dialogVisible = false;
                            sweetAlert.success();
                            _self.$refs.vuetable.refresh();
                        }
                    }) 
            },
            turnToEdit(model,id) {
                this.$router.push({ path: '/dashboard/'+model+'/'+id+'/edit' });
            },
            deleteSuccess() {
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
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
                            let deleteUrl = '/api/category/' + data.id;
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
                    axios.get('/api/category/' + data.id)
                        .then(function (res) {
                            _self.editDialog(res.data.data);
                        })
                        .catch(function (error) {
                            sweetAlert.error();
                        })
                    
                }
            }
        }
    }
</script>

<style>
    .form-horizontal .control-label{
        font-size: 14px;
        text-align: left;
    }
    .el-select{
        display: block;
    }
    .el-input__inner{
        border: 1px solid #e6e6e6;
    }
    .modal-content .block{
        margin-bottom: 0;
    }
</style>