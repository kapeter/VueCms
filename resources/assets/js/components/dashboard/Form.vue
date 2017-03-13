<template>
	<form>
    	<div class="row">
			<div class="col-sm-9">
				<div class="block">
					<div class="block-content">
		     			<div class="form-group" v-for="field in fields">
		     				<label :for="field.name">{{ field.label }}</label>
		     				<div v-if="field.type == 'text'">
		     					<input type="text" class="form-control" :name="field.name" v-model="field.value">
		     				</div>
		     				<div v-if="field.type == 'textarea'">
		     					<textarea class="form-control" :name="field.name" v-model="field.value" :rows=" !field.rows ? 3 : field.rows"></textarea>
		     				</div>
		     				<div v-if="field.type == 'editor'">
		     					<textarea id="editor" :name="field.name" v-model="field.value"></textarea>
		     				</div>
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
						<h3 class="block-title">发布</h3>
					</div>
					<div class="block-content">
						<slot name="form-publish"></slot>
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
			actionUrl: {
				type: String,
				default: ''
			},
			
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
	        this.simplemde = new SimpleMDE({
	            element: document.getElementById("editor"),
	            autoDownloadFontAwesome: true,
	            tabSize: 4
	        });
		},
		methods: {
			toggleBlock(name) {
				this.isHidden[name] = !this.isHidden[name]; 
			},
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

