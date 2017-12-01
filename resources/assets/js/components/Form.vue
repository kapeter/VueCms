<template>
	<div>
		<form enctype="multipart/form-data">
	    	<div class="row">
				<div class="col-lg-9 col-md-8">
					<div class="block">
						<div class="block-content">
			     			<div class="form-group" v-for="formField in formFields" :class="{ 'has-error' : errors.has(formField.name) }">
			     				<label :for="formField.name">
			     					{{ formField.label }}
			     					<span class="font-s13" v-if="formField.info">（<i class="fa fa-info"></i> {{ formField.info }}）</span>
			     				</label>
			     				<div v-if="formField.type == 'text'">
			     					<input type="text" class="form-control" :name="formField.name" v-model="formField.value" v-validate="formField.validate" :data-vv-as="formField.label">
			     				</div>
			     				<div v-if="formField.type == 'textarea'">
			     					<textarea class="form-control" :name="formField.name" v-model="formField.value" :rows=" !formField.rows ? 3 : formField.rows" v-validate="formField.validate" :data-vv-as="formField.label"></textarea>
			     				</div>
			     				<div v-if="formField.type == 'editor'" class="editor-content">
			     					<button class="btn btn-sm btn-default" @click.prevent="mediaDialogVisible = true">
										<i class="fa fa-cloud-upload"></i> 添加媒体
									</button>	
			     					<textarea id="editor" :name="formField.name"></textarea>
			     				</div>
			     				<div v-if="formField.type == 'checkbox'">
								  	<el-checkbox-group v-model="formField.value">
								    	<el-checkbox v-for=" item in formField.option" :label="item" :key="item"></el-checkbox>
								  	</el-checkbox-group>
			     				</div>
			     				<div class="help-block animated fadeInDown"  v-show="errors.has(formField.name)">
		                            {{ errors.first(formField.name) }}
		                        </div>
			     			</div>
			     		</div>
			     	</div>
			    </div>
			    <div class="col-lg-3 col-md-4">
			    	<!-- 发布模块 -->
			    	<div class="block block-themed">
						<div class="block-header bg-info">
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
					<div class="block block-themed">
						<div class="block-header bg-info">
							<h3 class="block-title">分类目录</h3>
						</div>
						<div class="block-content">
							<!-- 分类目录 -->
							<div class="form-category row">
							  	<el-radio-group v-model="categoryData">
							    	<li v-for = "category in categories" class="col-md-6">
							    		<el-radio :label="category.id">
							    			{{ category.name }}
							    		</el-radio>
							    	</li>
							  	</el-radio-group>
							</div>
						</div>
					</div> 
					<slot name="moreBox"></slot>
			    </div>
			</div>	
		</form>
		<ElDialog title="添加媒体" :visible.sync="mediaDialogVisible"  width="90%" top="2vh">
			<vue-media :isClosed="!mediaDialogVisible"></vue-media>
			<span slot="footer">
	            <button class="btn btn-default" @click="mediaDialogVisible = false">关  闭</button>
	            <button class="btn btn-info" @click="copyMediaUrl()" :disabled="!$store.state.mediaIsChecked">确定选择</button>
	        </span>
		</ElDialog>		
	</div>
</template>

<script>
	import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
	
	export default {
		props: {
		    formFields: {
		      	type: Array,
		      	required: true
		    },
		    moreParams: {
		    	type: Object,
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
        data() {
        	return {
				simplemde: '',
				uID: '',
				createdDate: '',
				updatedDate: '',
				publishedDate: '',
				categories: {},
				categoryData: 1,
				mediaDialogVisible: false,
        	}
        },
        computed: {
        	backUrl() {
        		return '/' + this.url;
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
			backToIndex() {
				let backPath = this.backUrl; 
				this.$router.push({ path: backPath });
			},
			// submit
			formSubmit(isPublish = false) {
				let _self = this;
				_self.$validator.validateAll().then((result) => {
                    if (result) {
						let param = _self.serialize();
						let backPath = _self.backUrl; 
						if ( param != false ){
							if (isPublish){
								param.append('isPublish', 'true');
							}
							param.append('category_id', _self.categoryData);

							let submitUrl = '';
							if (_self.action == 'create'){
								submitUrl = _self.url;
							}else{
								submitUrl = _self.url + '/' + _self.uID;
								param.append('_method', 'PUT');
							}
							_self.$http.post(submitUrl, param)
								.then(function (res) {
									 _self.$message.success();
									_self.$router.push({ path: backPath });
								})
								.catch(function (error) {
									 _self.$message.error();
								});
						}
                    }
                });			
			},
			// get category list
			getCategory() {
				let _self = this;
				let categoryUrl = 'category?model=' + _self.url;
        		_self.$http.get(categoryUrl)
        			.then(function (response) {
        				_self.categories = response.data.data;
        			})
			},
			// get data if the action is edit
			loadData() {
				let _self = this;
				_self.uID = _self.$route.params.id;
				let editUrl = _self.url + '/' + _self.uID;

        		_self.$http.get(editUrl)
        			.then(function (response) {
        				let data = response.data.data;
        				for (let i = 0; i < _self.formFields.length; i++ ){
        					let temp = _self.formFields[i]; 
							switch (temp.type)
							{
								case 'editor':
									_self.simplemde.value(data[temp.name])
									break;
								case 'checkbox':
									temp.value = [];
									if (data[temp.name] != undefined && data[temp.name] != null){
										let x = data[temp.name].split(',');
										x.forEach((item) => {
											item = parseInt(item);
											temp.value.push(temp.option[item]);
										});										
									}
									break;
								default:
									temp.value = data[temp.name];
									break;
							}
        				}
        				for (let x in _self.moreParams){
        					let temp = _self.moreParams[x];
        					temp.value = data[temp.name];
        				}
        				_self.createdDate = _self.dateFormat(data['created_at']);
        				_self.updatedDate = _self.dateFormat(data['updated_at']);
        				_self.publishedDate = _self.dateFormat(data['published_at']);
        				_self.categoryData = data['category'].id;
        			});
			},

			// change the data format
			dateFormat (value) {
        		return (value == null) ? '' : value.date.substring(0,10);
        	},
			// refresh data if the action is create
			freshData() {
				for (let i = 0; i < this.formFields.length; i++ ){
					if (this.formFields[i].value.constructor === Array){
						this.formFields[i].value = [];
					}else{
						this.formFields[i].value = '';
					}
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
		            autoDownloadFontAwesome: false,
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
				for (let i = 0; i < this.formFields.length; i++ ){
					let temp = this.formFields[i];
					switch (temp.type)
					{
						case 'editor':
							temp.value = this.simplemde.value();
							break;
						case 'checkbox':
							let x = [];
							for (let i = 0; i < temp.value.length; i++){
								if (temp.option.includes(temp.value[i])) {
									x.push(temp.option.indexOf(temp.value[i]))
								}
							} 
							temp.value = x.join(',');
							break;
						default:
							break;
					}
					formData.append(temp.name, temp.value);
				}

				for (let x in this.moreParams){
					let temp = this.moreParams[x];
					formData.append(temp.name, temp.value);
				}

				return formData;
			},
			// delete the data and back to the list
			turnToTrash() {
				let _self = this;
				let backPath = _self.backUrl; 
                _self.$message.delete(function(){
                    let deleteUrl = _self.url + '/' + _self.uID;
                    _self.$http.delete(deleteUrl)
                        .then(function(response){
                            if (response.status == 200){
                                _self.$message.success();
                                _self.$router.push({ path: backPath });
                            }
                        })
                        .catch(function (error) {
                            _self.$message.error();
                        });
                }) 
			},

			copyMediaUrl() {
				this.mediaDialogVisible = false;
				this.simplemde.value(this.simplemde.value() +  this.$store.state.checkedMedia.url);
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
		line-height: 34px;
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
	.editor-content img{
		max-width: 100%;
	}
	.CodeMirror{
		padding: 0 10px;
		border-radius: 0px;
	}
	.el-checkbox{
		color: #666
	}
	.el-checkbox__inner{
		border-radius: 0
	}
	.editor-toolbar{
		border-radius: 0;
	}
</style>

