<template>
	<div>
        <page-heading title="登录日志" subTitle="Signin Log" :crumbs="crumbs"></page-heading>
        <div class="content">
	     	<div class="block">
                <div class="block-header remove-padding-b">
					<span class="text-info"><i class="fa fa-exclamation-triangle"></i> 登录日志只保留近30天的记录。</span>
                </div>
	     		<div class="block-content">
	     			<div class="table-responsive">
						<vuetable ref="vuetable"
						    api-url="log/signin"
						    :tfields="tfields"
						    :sort-order="sortOrder"
						    :css="css.table"
						    @vuetable:pagination-data="onPaginationData">
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
		    	crumbs: [
		    		{to: null, text: '登录日志'}
		    	],
		      	tfields: [
			        {
			          name: 'email',
			          title: '登录邮箱',
			          titleClass: 'text-left',
			          dataClass: 'text-left',
			        },
			        {
			          name: 'username',
			          title: '登录用户',
			          titleClass: 'text-center',
			          dataClass: 'text-center',
			        },
			        {
			          name: 'ip',
			          title: 'IP地址',
			          titleClass: 'text-center',
			          dataClass: 'text-center',
			        },
			        {
			          title: '操作时间',
			          name: 'created_at',
			          titleClass: 'text-center',
			          dataClass: 'text-center'
			        }
		      	],
		      	sortOrder: [
		        	{ field: 'created_at', sortField: 'created_at', direction: 'desc'}
		      	],
                css: {
                    table: {
                      tableClass: 'table table-striped',
                    },
                },
		    }
		},
        methods: {
		    onPaginationData (paginationData) {
		      	this.$refs.pagination.setPaginationData(paginationData);
		      	this.$refs.paginationInfo.setPaginationData(paginationData);
		    },
		    onChangePage (page) {
		      	this.$refs.vuetable.changePage(page)
		    }
        }
    }
</script>

<style>
	.label{
		font-weight: normal;
		padding: 3px 7px;
	}
	.pagination-info,.filter-bar{
		display: none;
	}
	@media screen and (min-width: 768px) {
		.pagination-info,.filter-bar{
			display: block;
		}
	}
</style>


