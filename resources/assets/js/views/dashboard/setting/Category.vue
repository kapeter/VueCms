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
                            <a @click="openModal('newCategory')"><i class="fa fa-plus"></i> 新增目录</a>
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
	</div>
</template>

<script> 
    export default {
        data () {
            return {
                crumbs: [
                    {to: null, text: '分类目录'},
                ],
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
                      name: 'updated_at',
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
                return '<h4 class="h5 push-5 text-primary">'+valArr[0]+'</h4><div class="font-s13 text-muted">/ '+valArr[1]+'</div>';
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
                            let deleteUrl = '/api/post/' + data.id;
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