<template>
	<div>
        <page-heading title="文章管理" subTitle="Post"></page-heading>
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
	     			<router-link to="/dashboard/post/create" class="btn btn-minw btn-square btn-info pull-right">
	     				<i class="fa fa-paint-brush"></i>  写文章
	     			</router-link>
	     		</div>
	     		<div class="block-content">
					<vuetable ref="vuetable"
					    api-url="http://vuetable.ratiw.net/api/users"
					    :fields="['name', 'email', 'birthdate']"
					    pagination-path=""
					></vuetable> 
					<vuetable-pagination ref="pagination"></vuetable-pagination>
			    </div>  		
	     	</div>        	
        </div>
	</div>
</template>

<script> 
    export default {
        data () {
        	return {
        		columns: [
	                'name',
	                'nickname',
	                'email',
	                'birthdate',
	                '__actions'
	            ],
	            itemActions: [
	                { name: 'view-item', label: 'view', icon: 'fa fa-eyes', class: 'btn btn-xs btn-default' },
	                { name: 'edit-item', label: 'edit', icon: 'fa fa-pencil', class: 'btn btn-xs btn-default'},
	                { name: 'delete-item', label: 'delete', icon: 'fa fa-times', class: 'btn btn-xs btn-default' }
	            ],
			      css: {
			        table: {
			          tableClass: 'table table-bordered table-striped table-hover',
			          ascendingIcon: 'glyphicon glyphicon-chevron-up',
			          descendingIcon: 'glyphicon glyphicon-chevron-down'
			        },
			        pagination: {
			          wrapperClass: 'pagination',
			          activeClass: 'active',
			          disabledClass: 'disabled',
			          pageClass: 'page',
			          linkClass: 'link',
			        },
			        icons: {
			          first: 'glyphicon glyphicon-step-backward',
			          prev: 'glyphicon glyphicon-chevron-left',
			          next: 'glyphicon glyphicon-chevron-right',
			          last: 'glyphicon glyphicon-step-forward',
			        },
			      },
        	}
        },
        methods: {
            viewProfile: function(id) {
                console.log('view profile with id:', id)
            }
        },
        events: {
            'vuetable:action': function(action, data) {
                console.log('vuetable:action', action, data)
                if (action == 'view-item') {
                    this.viewProfile(data.id)
                }
            },
            'vuetable:load-error': function(response) {
                console.log('Load Error: ', response)
            }
        }
    }
</script>

