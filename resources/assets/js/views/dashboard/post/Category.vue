<template>
	<div>
        <page-heading title="分类目录" subTitle="Category"></page-heading>
        <div class="content">
	     	<div class="block block-bordered">
	     		<div class="block-header">
	     			<div class="row">
	     				<div class="col-sm-6">
		     				<filter-bar></filter-bar>
		     			</div>
		     			<div class="col-sm-6">
		     				<router-link to="/dashboard/post/create" class="btn btn-minw btn-info pull-right">
		     					<i class="fa fa-paint-brush"></i>  新增目录
		     				</router-link>	
		     			</div>	
	     			</div>
	     		</div>

	     		<div class="block-content">
					<vuetable ref="vuetable"
					    api-url="http://vuetable.ratiw.net/api/users"
					    pagination-path=""
					    :fields="fields"
					    :sort-order="sortOrder"
					    @vuetable:pagination-data="onPaginationData"
					    :append-params="moreParams"
					></vuetable> 
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
		data () {
		    return {
		      fields: [
		        {
		          name: 'name',
		          sortField: 'name',
		        },
		        {
		          name: 'email',
		          sortField: 'email'
		        },
		        {
		          name: 'birthdate',
		          sortField: 'birthdate',
		          titleClass: 'text-center',
		          dataClass: 'text-center',
		        },
		        {
		          name: 'nickname',
		          sortField: 'nickname',
		        },
		        {
		          name: 'gender',
		          sortField: 'gender',
		          titleClass: 'text-center',
		          dataClass: 'text-center',
		        },
		        {
		          name: 'salary',
		          sortField: 'salary',
		          titleClass: 'text-center',
		          dataClass: 'text-right',
		        },
		        {
		          name: '__component:custom-actions',
		          title: 'Actions',
		          titleClass: 'text-center',
		          dataClass: 'text-center'
		        }
		      ],
		      sortOrder: [
		        { field: 'email', sortField: 'email', direction: 'asc'}
		      ],
		      moreParams: {}
		    }
		},
        methods: {
		    onPaginationData (paginationData) {
		      	this.$refs.pagination.setPaginationData(paginationData);
		      	this.$refs.paginationInfo.setPaginationData(paginationData);
		    },
		    onChangePage (page) {
		      	this.$refs.vuetable.changePage(page)
		    },
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
		    }
        }
    }
</script>