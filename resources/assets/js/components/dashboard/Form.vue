<template>
	<form>
    	<div class="row">
			<div class="col-sm-9">
				<div class="block">
					<div class="block-content">
		     			<div class="form-group" v-for="field in fields" :class="{ 'has-error' : field.error  }">
		     				<label :for="field.name">{{ field.label }}</label>
		     				<div v-if="field.type == 'text'">
		     					<input type="text" class="form-control" :name="field.name" v-model="field.value">
		     				</div>
		     				<div v-if="field.type == 'textarea'">
		     					<textarea class="form-control" :name="field.name" v-model="field.value" :rows=" !field.rows ? 3 : field.rows"></textarea>
		     				</div>
		     				<div v-if="field.type == 'editor'">
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
								<button class="btn btn-default pull-left" @click.prevent="formSubmit(false)">保存为书稿</button>
							</div>
							<div class="col-sm-6">
								<button class="btn btn-info pull-right" @click.prevent="formSubmit(true)">
									{{ action == 'edit' ? '更 新' : '发 布' }}
								</button>
							</div>
						</div>
					</div>
				</div>
				<!-- 分类目录 -->
				<div class="block block-bordered" :class="{ 'block-opt-hidden': isHidden.block_2 }">
					<div class="block-header">
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
						<slot name="form-category"></slot>	
					</div>
				</div> 

		    </div>
		</div>	
	</form>
</template>

<script>
	import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
	
	export default {
		props: {
		    fields: {
		      	type: Array,
		      	required: true
		    },
			url: {
				type: String,
				default: ''
			},
			action: {
				type: String,
				required: true
			}
			
		},
        data() {
        	return {
    			isHidden: {
					block_1: false,
					block_2: false
				},
				simplemde: '',
				uID: '',
        	}
        },
        computed: {
        	apiUrl() {
        		return '/api/' + this.url;
        	},
        	backUrl() {
        		return '/dashboard/' + this.url;
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
		},
		methods: {
			toggleBlock(name) {
				this.isHidden[name] = !this.isHidden[name]; 
			},
			// submit
			formSubmit(isPublish = false) {
				for (let i = 0; i < this.fields.length; i++ ){
					this.fields[i].error = false;
				}
				let param = this.serialize();
				let backPath = this.backUrl; 
				if ( param != false ){
					if (isPublish){
						param.append('isPublish', 'true');
					}

					let submitUrl = '';
					if (this.action == 'create'){
						submitUrl = this.apiUrl;
					}else{
						submitUrl = this.apiUrl + '/' + this.uID;
						param.append('_method', 'PUT');
					}

					axios.post(submitUrl, param)
						.then(function (res) {
							sweetAlert.success();
							VM.$router.push({ path: backPath });
						})
						.catch(function (error) {
							sweetAlert.error();
						    console.log(error);
						});
				}				
			},
			// get data if the action is edit
			loadData() {
				this.uID = this.$route.params.id;
				let editUrl = this.apiUrl + '/' + this.uID;
        		let _self = this;
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
        			});
			},
			// refresh data if the action is create
			freshData() {
				for (let i = 0; i < this.fields.length; i++ ){
					this.fields[i].value = '';
				}
			},
			// new a editor if needed
			newEditor() {
				this.simplemde = new SimpleMDE({
		            element: document.getElementById("editor"),
		            autoDownloadFontAwesome: true,
		            tabSize: 4
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
			}
		},
	}
</script>

<style>
	@import '/css/simplemde.css';

	.form-group > label{
		font-size: 15px;
		font-weight: 400;
	}
	.block-content{
		padding-bottom: 20px;
	}
	textarea {
		resize: none;
	}
</style>

