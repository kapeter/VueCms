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
								<button class="btn btn-default pull-left" @click.prevent="formStore()">保存为书稿</button>
							</div>
							<div class="col-sm-6">
								<button class="btn btn-info pull-right" @click.prevent="formPublish()">
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
			apiUrl: {
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
        	}
        },
		mounted() {
			let editor = document.getElementById("editor");
			let hasEditor = false;
			for (let i = 0; i < this.fields.length; i++ ){
				this.fields[i]['value'] = '';
				if (this.fields[i].type == 'editor' ){
					hasEditor = true;
					break;
				}
			}
			if (editor && hasEditor){
		        this.simplemde = new SimpleMDE({
		            element: editor,
		            autoDownloadFontAwesome: true,
		            tabSize: 4
		        });				
			}
		},
		methods: {
			toggleBlock(name) {
				this.isHidden[name] = !this.isHidden[name]; 
			},
			// publish btn
			formPublish() {
				for (let i = 0; i < this.fields.length; i++ ){
					this.fields[i].error = false;
				}
				let param = this.serialize();
				if ( param != false ){
					axios.post(this.apiUrl, param);
				}				
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

