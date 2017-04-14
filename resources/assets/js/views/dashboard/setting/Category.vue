<template>
	<div>
        <page-heading title="分类目录" subTitle="All Categories" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
            <!-- Frequently Asked Questions -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <ul class="block-options">
                        <li>
                            <button type="button"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <ul class="block-options block-options-left">
                        <li>
                            <a @click="CreatedialogVisible = true"><i class="fa fa-plus"></i> 新增目录</a>
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
        <ElDialog title="新增目录" v-model="CreatedialogVisible" size="tiny">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">目录名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="slug" class="col-sm-2 control-label">唯一标识</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.slug">
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">所属模型</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="formData.model">
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
                        <textarea class="form-control" v-model="formData.parent_id" rows="3"></textarea>
                    </div>
                </div>
            </div>
          <span slot="footer">
            <button class="btn btn-default" @click="CreatedialogVisible = false">取 消</button>
            <button class="btn btn-primary" @click="dialogVisible = false">确 定</button>
          </span>
        </ElDialog>
        <!-- END Create Model-->
	</div>
</template>

<script>
    import ElDialog from '../../../packages/dialog'
    import Select from '../../../packages/select'

    export default {
        components: {
            ElDialog,
            Select
        },
        data () {
            return {
                CreatedialogVisible: false,
                crumbs: [
                    {to: null, text: '分类目录'},
                ],
                formData: {
                    name: '',
                    model: '',
                    description: '',
                    slug: '',
                },
                fields: [
                    {
                      title: '名称  /  唯一标识',
                      name: 'name',
                      callback: 'devideName'
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
        methods: {
            devideName (value) {
                let valArr = value.split('|');
                return '<h4 class="h5 text-primary">'+valArr[0]+'</h4><span class="font-s13 text-muted">/ '+valArr[1]+'</span>';
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
                if (action == 'delete-item'){
                    var _self = this;
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
                    this.$router.push({ name: 'editPost', params: { id: data.id }});
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
</style>