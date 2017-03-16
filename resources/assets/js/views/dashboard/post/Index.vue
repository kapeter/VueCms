<template>
	<div>
        <page-heading title="所有文章" subTitle="All Articles"></page-heading>
        <div class="content">
	     	<div class="block block-bordered">
	     		<div class="block-header">
	     			<div class="row">
	     				<div class="col-sm-6">
		     				<filter-bar></filter-bar>
		     			</div>
		     			<div class="col-sm-6">
		     				<router-link to="/dashboard/post/create" class="btn btn-minw btn-info pull-right">
								写文章
		     				</router-link>	
		     			</div>	
	     			</div>
	     		</div>

	     		<div class="block-content">
					<vuetable ref="vuetable"
					    api-url="/api/post"
					    :fields="fields"
					    :sort-order="sortOrder"
					    @vuetable:pagination-data="onPaginationData"
					    :append-params="moreParams">
						<template slot="actions" scope="props">
					    	<div class="custom-actions">
	        					<button class="btn btn-sm btn-default" @click="itemAction('edit-item', props.rowData)"><i class="fa fa-pencil"></i></button>
	        					<button class="btn btn-sm btn-danger" @click="itemAction('delete-item', props.rowData)"><i class="fa fa-times"></i></button>
					    	</div>
					    </template>
					</vuetable> 
					<div class="row">
						<div class="col-sm-6">
							<vuetable-pagination-info ref="paginationInfo" info-class="pagination-info"></vuetable-pagination-info>
						</div>
						<div class="col-sm-6">
							<vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
						</div>
					</div>
			    </div>  		
	     	</div>        	
        </div>
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
		data () {
		    return {
		      	fields: [
			        {
			          title: '标题',
			          name: 'title',
			          sortField: 'title',
			        },
			        {
			          title: '作者',
			          name: 'last_user',
			          titleClass: 'text-center',
			          dataClass: 'text-center',
			        },
			        {
			          title: '发布时间',
			          name: 'published_at',
			          sortField: 'published_at',
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
		      	sortOrder: [
		        	{ field: 'published_at', sortField: 'published_at', direction: 'desc'}
		      	],
		      	moreParams: {},
		    }
		},
        methods: {
        	dateFormat (value) {
        		return (value == null) ? '' : value.substring(0,10);
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
	                        let deleteUrl = '/api/post/' + data.id + '?token=' + localStorage.token;
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

	            }
	        }
        },
        events: {
		    'filter-set' (filterText) {
		      	this.moreParams = {
		        	filter: filterText
		      	}
		      	Vue.nextTick( () => this.$refs.vuetable.refresh() )
		    },
		    'filter-reset' () {
		      	this.moreParams = {}
		      	Vue.nextTick( () => this.$refs.vuetable.refresh() )
		    },
        },
    }
</script>


