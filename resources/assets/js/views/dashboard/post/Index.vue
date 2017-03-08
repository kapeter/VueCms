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
		     					<i class="fa fa-paint-brush"></i>  写文章
		     				</router-link>	
		     			</div>	
	     			</div>
	     		</div>

	     		<div class="block-content">
					<vuetable ref="vuetable"
					    api-url="/api/posts"
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
		          title: '标题',
		          name: 'title',
		          sortField: 'title',
		        },
		        {
		          title: '摘要',
		          name: 'description',
		          sortField: 'description'
		        },
		        {
		          title: '作者',
		          name: 'last_user_id',
		          sortField: 'last_user_id',
		          titleClass: 'text-center',
		          dataClass: 'text-center',
		        },
		        {
		          title: '发布时间',
		          name: 'published_at',
		          sortField: 'published_at',
		        },
		        {
		          name: '__component:custom-actions',
		          title: 'Actions',
		          titleClass: 'text-center',
		          dataClass: 'text-center'
		        }
		      ],
		      sortOrder: [
		        { field: 'title', sortField: 'title', direction: 'asc'}
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


