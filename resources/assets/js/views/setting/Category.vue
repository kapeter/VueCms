<template>
	<div>
        <page-heading title="分类目录" subTitle="All Categories" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
            <!-- Frequently Asked Questions -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-button">
                        <li>
                            <a @click="createDialog()" class="btn btn-info"><i class="fa fa-plus"></i> 新增目录</a>
                        </li>
                    </ul>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <vuetable ref="vuetable"
                            :api-url="routeList.browseUrl"
                            :tfields="tfields"
                            :css="css.table"
                            @vuetable:pagination-data="onPaginationData"
                            :append-params="moreParams">
                            <template slot="devideName" slot-scope="props">
                                <h4 class="h5 text-info">{{ props.rowData.name }}</h4>
                                <span class="font-s12 text-muted">{{ props.rowData.slug }}</span>
                            </template>
                            <template slot="recentLink" slot-scope="props">
                                <span v-if="props.rowData.detail.count == 0">无</span>
                                <span v-else>
                                    <a @click="turnToEdit(props.rowData.detail.model, props.rowData.detail.article.id)" href="javascript:;">
                                        {{ props.rowData.detail.article.title }}
                                    </a>
                                    <br>
                                    <em class="font-s12 text-muted">updated {{ props.rowData.detail.article.updated_at }}</em>
                                </span>
                            </template>
                            <template slot="actions" slot-scope="props">
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
        <ElDialog :title="modalTitle" :visible.sync="dialogVisible" width="36%">
            <form class="form-horizontal">
                <input type="hidden" name="id" v-model="currentID">
                <div class="form-group" :class="{ 'has-error' : errors.has('name')  }">
                    <label for="name" class="col-sm-2 control-label">目录名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name" name="name" v-validate="'required'" data-vv-as="目录名称">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('name')">
                            {{ errors.first('name') }}
                        </div>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error' : errors.has('slug') || !uniqueCheck }">
                    <label for="slug" class="col-sm-2 control-label">唯一标识</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.slug" placeholder="仅支持英文、数字" v-validate="'required|alpha_num'" name="slug">
                        <div class="help-block animated fadeInDown"  v-show="errors.has('slug')">
                            {{ errors.first('slug') }}
                        </div>
                        <div class="help-block animated fadeInDown" v-show="!uniqueCheck">唯一标识重复</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">所属模型</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.model" placeholder="请选择模型">
                            <el-option
                                v-for="item in models"
                                :label="item.label"
                                :value="item.value" :key="item.value">
                            </el-option>
                      </el-select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">目录描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" v-model="formData.description" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="parent" class="col-sm-2 control-label">父级目录</label>
                    <div class="col-sm-10">
                        <el-select v-model="formData.parent_id" placeholder="请选择父级目录">
                            <el-option label="无" :value="0"></el-option>
                            <el-option
                              v-for="parent in parentCategory" v-if="parent.id != currentID"
                              :label="parent.name"
                              :value="parent.id" :key="parent.slug">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </form>
          <span slot="footer">
            <button class="btn btn-default" @click="dialogVisible = false">取 消</button>
            <button class="btn btn-info" @click="submitCategory()">确 定</button>
          </span>
        </ElDialog>
        <!-- END Create Model-->
	</div>
</template>

<script>
    import models from '../../config/models.js'

    export default {
        data () {
            return {
                models: models,
                parentCategory: [],
                dialogVisible: false,
                crumbs: [
                    {to: null, text: '分类目录'},
                ],
                routeList: {
                    browseUrl : 'category',
                },
                formData: {
                    name: '',
                    slug: '',
                    model: 'post',
                    description: '',
                    parent_id: 0
                },
                uniqueCheck: true,
                modalTitle: '新增目录',
                currentID: 0,
                tfields: [
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
            _self.$http.get(_self.routeList.browseUrl)
                .then(function (res) {
                    _self.parentCategory = res.data.data;
                })
        },
        methods: {
            createDialog() {
                this.formData = {
                    name: '',
                    slug: '',
                    model: 'post',
                    description: '',
                    parent_id: 0
                };
                this.currentID = 0;
                this.uniqueCheck = true;
                this.errors.clear();
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
                this.uniqueCheck = true;
                this.errors.clear();
                this.modalTitle = '修改目录';
                this.dialogVisible = true;
            },
            submitCategory() {
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
                                    _self.dialogVisible = false;
                                    _self.$message.success();
                                    _self.$refs.vuetable.refresh();
                                }
                            });
                    }
                });
            },
            turnToEdit(model,id) {
                this.$router.push({ path: '/'+model+'/'+id+'/edit' });
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
    .el-select-dropdown{
        z-index: 3000!important;
    }
    .el-input__inner{
        border: 1px solid #e6e6e6;
    }
    .modal-content .block{
        margin-bottom: 0;
    }
</style>