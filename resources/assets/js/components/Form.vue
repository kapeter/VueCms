<template>
	<div>
		<form enctype="multipart/form-data">
	    	<div class="row">
				<div class="col-sm-9">
					<div class="block">
						<div class="block-content">
			     			<div class="form-group" v-for="field in fields" :class="{ 'has-error' : field.error  }">
			     				<label :for="field.name">
			     					{{ field.label }}
			     					<span class="text-muted font-s13" v-if="field.info">（<i class="fa fa-info"></i> {{ field.info }}）</span>
			     				</label>
			     				<div v-if="field.type == 'text'">
			     					<input type="text" class="form-control" :name="field.name" v-model="field.value">
			     				</div>
			     				<div v-if="field.type == 'textarea'">
			     					<textarea class="form-control" :name="field.name" v-model="field.value" :rows=" !field.rows ? 3 : field.rows"></textarea>
			     				</div>
			     				<div v-if="field.type == 'editor'" class="editor-content">
			     					<button class="btn btn-sm btn-default" @click.prevent="mediaDialogVisible = true">
										<i class="fa fa-cloud-upload"></i> 添加媒体
									</button>	
			     					<textarea id="editor" :name="field.name"></textarea>
			     				</div>
			     				<div class="help-block animated fadeInDown" v-show="field.error">提示：{{ field.label }}不能为空</div>
			     			</div>
			     		</div>
			     	</div>
			    </div>
			    <div class="col-sm-3">
			    	<!-- 发布模块 -->
			    	<div slot="form-publish" class="block block-themed" :class="{ 'block-opt-hidden': isHidden.block_1 }">
						<div class="block-header bg-info">
	                        <ul class="block-options">
	                            <li>
	                                <button type="button" @click="toggleBlock('block_1')">
	                                	<i class="si" :class="[isHidden.block_1 ? 'si-arrow-down' : 'si-arrow-up']"></i>
	                                </button>
	                            </li>
	                        </ul>
							<h3 class="block-title">发布模块</h3>
						</div>
						<div class="block-content">
							<div class="row">
								<div class="col-sm-6">
									<button class="btn btn-default pull-left">预 览</button>
								</div>
								<div class="col-sm-6">
									<button class="btn btn-default pull-right"  @click.prevent="backToIndex()">
										返回列表
									</button>
								</div>
							</div>
							<div class="publish-status">
								<p>
									<i class="fa fa-calendar-plus-o"></i> 首次创建：
									<span>{{ createdDate }}</span>
								</p>
								<p v-if="updatedDate != ''">
									<i class="fa fa-calendar-check-o"></i> 最后修改：
									<span>{{ updatedDate }}</span>
								</p>
								<p v-if="">
									<i class="fa fa-calendar"></i> 发布状态：
									<span v-html="publishedStatus"></span>
								</p>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<button v-if="action == 'create'" class="btn btn-default pull-left" @click.prevent="formSubmit(false)">
										保存为书稿
									</button>
									<button v-else class="btn btn-danger pull-left" @click.prevent="turnToTrash()">
										移动到回收站
									</button>
								</div>
								<div class="col-sm-6">
									<button class="btn btn-info pull-right" @click.prevent="formSubmit(true)">
										<i class="fa fa-paper-plane"></i> {{ action == 'edit' ? '更 新' : '发 布' }}
									</button>
								</div>
							</div>							
						</div>
					</div>
					<!-- 分类目录 -->
					<div class="block" :class="{ 'block-opt-hidden': isHidden.block_2 }">
						<div class="block-header" style="border-bottom: 1px solid #e9e9e9;">
	                        <ul class="block-options">
	                            <li>
	                                <button type="button" @click="toggleBlock('block_2')">
	                                	<i class="si" :class="[isHidden.block_2 ? 'si-arrow-down' : 'si-arrow-up']"></i>
	                                </button>
	                            </li>
	                        </ul>
							<h3 class="block-title">分类目录</h3>
						</div>
						<div class="block-content">
							<!-- 分类目录 -->
							<div class="form-category">
							  	<el-radio-group v-model="categoryData">
							    	<li v-for = "category in categories">
							    		<el-radio :label="category.id">
							    			{{ category.name }}
							    		</el-radio>
							    	</li>
							    	<li>
							    		<el-radio :label="0">未分类</el-radio>
							    	</li>
							  	</el-radio-group>
							</div>
						</div>
					</div> 

			    </div>
			</div>	
		</form>
		<ElDialog title="添加媒体" v-model="mediaDialogVisible" size="large">
			<vue-media></vue-media>
		</ElDialog>		
	</div>
</template>

<script>
	import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
	import ElDialog from '../packages/dialog'
	
	export default {
		props: {
		    fields: {
		      	type: Array,
		      	required: true
		    },
			url: {
				type: String,
				required: true
			},
			action: {
				type: String,
				required: true
			}
		},
        components: {
            ElDialog,
        },
        data() {
        	return {
    			isHidden: {
					block_1: false,
					block_2: false
				},
				simplemde: '',
				uID: '',
				createdDate: '',
				updatedDate: '',
				publishedDate: '',
				categories: {},
				categoryData: 0,
				mediaDialogVisible: false
        	}
        },
        computed: {
        	apiUrl() {
        		return '/api/' + this.url;
        	},
        	backUrl() {
        		return '/dashboard/' + this.url;
        	},
        	publishedStatus() {
        		return  this.publishedDate != '' ? '于 <u class="text-primary">'+ this.publishedDate + '</u> 发布' : '未发布';
        	}
		},
		mounted() {	
			if (document.getElementById("editor")){
				this.newEditor();			
			}	
			if (this.action && this.action == 'edit'){
				this.loadData();
			}else{
				this.freshData();
			}
			this.getCategory();
		},
		methods: {
			toggleBlock(name) {
				this.isHidden[name] = !this.isHidden[name]; 
			},
			backToIndex() {
				let backPath = this.backUrl; 
				this.$router.push({ path: backPath });
			},
			// submit
			formSubmit(isPublish = false) {
				var _self = this;
				for (let i = 0; i < _self.fields.length; i++ ){
					_self.fields[i].error = false;
				}
				let param = _self.serialize();
				let backPath = _self.backUrl; 
				if ( param != false ){
					if (isPublish){
						param.append('isPublish', 'true');
					}
					param.append('category_id', _self.categoryData);

					let submitUrl = '';
					if (_self.action == 'create'){
						submitUrl = _self.apiUrl;
					}else{
						submitUrl = _self.apiUrl + '/' + _self.uID;
						param.append('_method', 'PUT');
					}
					axios.post(submitUrl, param)
						.then(function (res) {
							sweetAlert.success();
							_self.$router.push({ path: backPath });
						})
						.catch(function (error) {
							sweetAlert.error();
						    console.log(error);
						});
				}				
			},
			// get category list
			getCategory() {
				let _self = this;
				let categoryUrl = '/api/category?model=' + _self.url;
        		axios.get(categoryUrl)
        			.then(function (response) {
        				_self.categories = response.data.data;
        			})
			},
			// get data if the action is edit
			loadData() {
				let _self = this;
				_self.uID = _self.$route.params.id;
				let editUrl = _self.apiUrl + '/' + _self.uID;

        		axios.get(editUrl)
        			.then(function (response) {
        				let data = response.data.data;
        				for (let i = 0; i < _self.fields.length; i++ ){
        					let temp = _self.fields[i]; 
        					temp.value = data[temp.name];
        					if (temp.type == 'editor'){
								_self.simplemde.value(temp.value);
        					}
        				}
        				_self.createdDate = _self.dateFormat(data['created_at']);
        				_self.updatedDate = _self.dateFormat(data['updated_at']);
        				_self.publishedDate = _self.dateFormat(data['published_at']);
        				_self.categoryData = data['category_id'];
        			});
			},

			// change the data format
			dateFormat (value) {
        		return (value == null) ? '' : value.date.substring(0,10);
        	},
			// refresh data if the action is create
			freshData() {
				for (let i = 0; i < this.fields.length; i++ ){
					this.fields[i].value = '';
				}
				this.createdDate = this.getNowDate();
			},
			// get today's date 
			getNowDate () {
				let myDate = new Date();
				let mon = myDate.getMonth() + 1;
				let day = myDate.getDate();
				return myDate.getFullYear() + "-" + (mon < 10 ? "0"+mon : mon) + "-" +(day < 10 ? "0"+day : day);				
			},
			// new a editor if needed
			newEditor() {
				this.simplemde = new SimpleMDE({
		            element: document.getElementById("editor"),
		            autoDownloadFontAwesome: true,
		            tabSize: 4,
		            toolbar: [
		            	"heading","bold","italic", "strikethrough",
		            	"|", 
		            	"quote","code","unordered-list","ordered-list","horizontal-rule",
		            	"|", 
		            	"link","image","table",
		            	"|",
		            	"preview","side-by-side","fullscreen",
		            	"|", 
		            	"guide"
		            ],
		        });	
			},
			// serialize data
			serialize() {
				let formData = new FormData();
				for (let i = 0; i < this.fields.length; i++ ){
					let temp = this.fields[i];
					switch (temp.type)
					{
						case 'editor':
							temp.value = this.simplemde.value();
							break;
						default:
							break;
					}
					if ( temp.required && temp.value == ''){
						temp.error = true;
						console.log(temp.error);
						return false;
					}
					formData.append(temp.name, temp.value);
				}
				return formData;
			},
			// delete the data and back to the list
			turnToTrash() {
				let _self = this;
				let backPath = _self.backUrl; 
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
                        let deleteUrl = '/api/post/' + _self.uID;
                        axios.delete(deleteUrl)
                            .then(function(response){
                            	if (response.status == 200){
									sweetAlert.success();
	                                VM.$router.push({ path: backPath });
                            	}
                            })
                            .catch(function (error) {
                            	sweetAlert.error();
							});
                    }
                });
			}
		},
	}
</script>

<style>
	@import '/css/simplemde.css';

	.block-content{
		padding-bottom: 20px;
	}
	textarea {
		resize: none;
	}
	.publish-status{
		margin:20px 0;
	}
	.publish-status p{
		margin-bottom: 10px;
		line-height: 1.5;
	}
	.form-category li{
		list-style: none;
		margin-bottom: 10px;
	}
	.editor-toolbar{
		padding-right: 100px;
	}
	.editor-content{
		position: relative;
	}
	.editor-content > button {
		position: absolute;
		right: 10px;
		top: 10px;
		z-index: 100;
	}
</style>

