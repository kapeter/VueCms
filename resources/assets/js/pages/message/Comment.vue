<template>
	<div>
        <page-heading title="评论管理" subTitle="All Comments" :crumbs="crumbs"></page-heading>
        <div class="content">
	     	<div class="block">
	     		<div class="block-header remove-padding-b">
     				<div class="pull-right">
	     				<filter-bar></filter-bar>
	     			</div>
	     		</div>

	     		<div class="block-content">
	     			<div class="table-responsive">
						<vuetable ref="vuetable"
						    :api-url="routeList.browseUrl"
						    :tfields="tfields"
						    :sort-order="sortOrder"
						    @vuetable:pagination-data="onPaginationData"
						    :append-params="moreParams">
							<template slot="author" slot-scope="props">
								<a :href="props.rowData.comment_author_url ? 'http://' + props.rowData.comment_author_url : '#'" target="_blank">
									<h5>{{ props.rowData.comment_author }}</h5>
								</a>
								<span class="font-s12">{{ props.rowData.comment_author_email }} / {{ props.rowData.comment_author_ip }}</span>
						    </template>
							<template slot="content" slot-scope="props">
								<div v-if="props.rowData.parent" class="font-w600 push-5">
									回复给: {{ props.rowData.parent.comment_author }}
								</div>
								<div class="font-s12">{{ props.rowData.comment_content }}</div>
						    </template>
							<template slot="relation" slot-scope="props">
								<router-link :to="'/'+ props.rowData.comment_type + '/' + props.rowData.comment_relation_id + '/edit'">
									{{ props.rowData.relation.title }}
								</router-link>
								<br>
								<em class="font-s12 text-muted">Updated at {{ props.rowData.relation.updated_at }}</em>
						    </template>
							<template slot="actions" slot-scope="props">
						    	<div class="custom-actions">
		        					<button class="btn btn-sm btn-default" @click="itemAction('edit-item', props.rowData)"><i class="fa fa-pencil"></i> 回复</button>
		        					<button class="btn btn-sm btn-danger" @click="itemAction('delete-item', props.rowData)"><i class="fa fa-times"></i> 删除</button>
						    	</div>
						    </template>
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

        <!-- 回复评论 -->
        <ElDialog title="回复评论" :visible.sync="dialogVisible" width="36%">
            <form>
                <div class="form-group" :class="{ 'has-error' : errors.has('content') }">
                    <label for="slug">回复给 {{replyInfo.comment_author}}：</label>
                    <textarea class="form-control" v-model="replyContent" name="content" v-validate="'required'" rows="5" placeholder="输入回复内容"></textarea>
                    <div class="help-block animated fadeInDown"  v-show="errors.has('content')">
                        {{ errors.first('content') }}
                    </div>
                </div>
            </form>
            <span slot="footer">
                <button class="btn btn-default" @click="dialogVisible = false">取 消</button>
                <button class="btn btn-info" @click="handleReply()">回  复</button>
            </span>
        </ElDialog>
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
		    		{to: null, text: '评论管理'},
		    	],
                routeList: {
                    browseUrl : 'comment',
                },
		      	tfields: [
			        {
			          	title: '评论者',
					  	name: '__slot:author',	
			        },
			        {
			          	title: '评论内容',
			          	name: '__slot:content',
			        },
			        {
			          	title: '关联内容',
						name: '__slot:relation',
			        },
			        {
			          	title: '评论时间',
			          	name: 'created_at',
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
		      	sortOrder: [
		        	{ field: 'created_at', sortField: 'created_at', direction: 'desc'}
		      	],
		      	moreParams: {},
		      	dialogVisible: false,
		      	replyContent: '',
		      	replyInfo: {}
		    }
		},
		mounted() {
			this.$root.$on('filter-set', (filterText) => {
		      	this.moreParams = {
		        	filter: filterText
		      	};
		      	Vue.nextTick( () => this.$refs.vuetable.refresh() );
		    });
		    this.$root.$on('filter-reset', () => {
		      	this.moreParams = {};
		      	Vue.nextTick( () => this.$refs.vuetable.refresh() );
		    });
		},
		beforeDestroy() {
			this.$root.$off('filter-set');
			this.$root.$off('filter-reset');
		},
        methods: {
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
		    changePublish(data) {
		    	let _self = this;
		    	_self.$http.post( _self.routeList.browseUrl + '/' + data.id +'/change',{is_publish: data.is_publish})
		    		.catch(function (res) {
		    			_self.$message.error();
		    		})
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
					_self.dialogVisible = true
					_self.replyInfo = data
					_self.replyContent = ''
	            }
	        },
	        handleReply () {
                let _self = this;
                _self.$validator.validateAll().then((result) => {
                    if (result) {
                        let state = _self.$store.state
                        let formData = {
                        	comment_author: state.theUser.name,
                        	comment_author_email: state.theUser.email,
                        	comment_content: _self.replyContent,
                        	comment_type: _self.replyInfo.comment_type,
                        	comment_relation_id: _self.replyInfo.comment_relation_id,
                        	comment_parent_id: _self.replyInfo.id
                        }
                        _self.$http.post(_self.routeList.browseUrl, formData)
                            .then(function (res) {
                                if (res.data.code){
                                    _self.$message.error();
                                }else{
                                    _self.dialogVisible = false;
                                    _self.$message.success();
                                    _self.$refs.vuetable.refresh();
                                }
                            });
                    }
                });  	
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
	.custom-actions{
		min-width: 128px;
	}
</style>


