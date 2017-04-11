<template>
	<div>
        <page-heading title="分类目录" subTitle="All Categories"></page-heading>
        <!-- Page Content -->
        <div class="content content-boxed">
            <!-- Frequently Asked Questions -->
            <div class="block">
                <div class="block-content block-content-full">
                    <vuetable ref="vuetable"
                        api-url="/api/category"
                        :fields="fields"
                        :append-params="moreParams">
                        <template slot="actions" scope="props">
                            <div class="custom-actions">
                                <button class="btn btn-sm btn-default" @click="itemAction('edit-item', props.rowData)"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-sm btn-danger" @click="itemAction('delete-item', props.rowData)"><i class="fa fa-times"></i></button>
                            </div>
                        </template>
                    </vuetable> 
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
                fields: [
                    {
                      title: '名称',
                      name: 'name',
                      sortField: 'name',
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
                      titleClass: 'text-center',
                      dataClass: 'text-center',
                    },
                    {
                      name: '__slot:actions',
                      title: '操作',
                      titleClass: 'text-center',
                      dataClass: 'text-center'
                    }
                ],
                moreParams: {},
            }
        },
        methods: {
            dateFormat (value) {
                return (value == null) ? '' : value.date.substring(0,10);
            },
            publishedLabel(value) {
                return value != null
                    ? '<span class="label label-info"><i class="fa fa-check"></i> 已发布</span>'
                    : '<span class="label label-warning"><i class="fa fa-exclamation-triangle"></i> 未发布</span>'
            },

            deleteSuccess() {
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
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