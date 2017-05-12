<template>
	<div>
        <page-heading title="接口日志" subTitle="Interface Log" :crumbs="crumbs"></page-heading>
        <div class="content">
	     	<div class="block">
	     		<div class="block-content">
	     			<span class="text-info"><i class="fa fa-exclamation"></i> 接口日志不记录GET请求, 且只保留近7天的记录。</span>
	     			<div class="table-responsive">
						<vuetable ref="vuetable"
						    api-url="/api/log"
						    :fields="fields"
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
		    		{to: null, text: '接口日志'}
		    	],
		      	fields: [
			        {
			          title: '控制器',
			          name: 'controller',
			        },
			        {
			          title: '方法',
			          name: 'action',
			          titleClass: 'text-center',
			          dataClass: 'text-center',
			        },
			        {
			          name: 'querystring',
			          title: '请求参数',
			        },
			        {
			          name: 'username',
			          title: '操作用户',
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
			          dataClass: 'text-center',
			          callback: 'dateFormat'
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
     		dateFormat (value) {
        		return (value == null) ? '' : value.date.slice(0,-7);
        	},
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


