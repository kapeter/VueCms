<template>
	<div>
        <page-heading title="媒体库" subTitle="Media Library" :crumbs="crumbs"></page-heading>
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
					<ul class="block-button">
						<li>
							<button class="btn btn-info" @click="addMediaVisible = true">
								<i class="fa fa-cloud-upload"></i> 添加媒体
							</button>
						</li>
						<li>
							<button class="btn btn-info" @click="createDictVisible = true">
								<i class="fa fa-plus"></i> 新增文件夹
							</button>
						</li>
					</ul>
	     		</div>

	     		<div class="block-content" style="min-height:350px;">
					<Media></Media>
			    </div>  		
	     	</div>   
        </div>
        <!-- 添加媒体Modal -->
        <ElDialog title="添加媒体" :visible.sync="addMediaVisible" size="tiny" :before-close="closeAddMedia">
        	<span class="text-info"><i class="fa fa-exclamation"></i> 若文件夹为空，则上传至媒体根目录。</span>
        	<div class="form-group">
	          	<el-cascader
	          		ref="upload-cascader"
				    :options="dictOptions"
				    v-model="selectedDict"
				    @change="handleChange"
				    :change-on-select=true
				    placeholder="请选择文件夹">
				</el-cascader>        		
        	</div>

        	<el-upload
        		ref="mediaUpload"
        		class="media-upload"
			  	drag
			  	:action="routeList.uploadUrl"
			  	:data="uploadData"
			  	:on-remove="removeFileInUpload"
			  	multiple>
			  	<i class="el-icon-upload"></i>
			  	<div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
			  	<div class="el-upload__tip" slot="tip">支持jpg、png、gif、mp3的文件格式，大小不超过2MB</div>
			</el-upload>
			<span slot="footer">
	            <button class="btn btn-default" @click="closeAddMedia()">关  闭</button>
	        </span>
        </ElDialog>
        <!-- 添加媒体Modal End-->

        <!-- 新增文件夹Modal -->
        <ElDialog title="新增文件夹" :visible.sync="createDictVisible" size="tiny">
        	<div class="form-group">
	          	<el-cascader
	          		ref="dict-cascader"
				    :options="dictOptions"
				    v-model="selectedDict"
				    @change="handleChange"
				    :change-on-select=true
				    placeholder="请选择父目录">
				</el-cascader>        		
        	</div>
			<div class="form-group" :class="{ 'has-error' : newDictObj.hasError  }">
				<input type="text" name="newDictName" class="form-control" placeholder="新文件夹名" v-model="newDictObj.value">
				<div class="help-block animated fadeInDown" v-show="newDictObj.hasError" v-html="newDictObj.errorText"></div>
			</div>
			<span class="text-info"><i class="fa fa-exclamation"></i> 请以纯数字或英文的方式命名文件夹。</span>
			<span slot="footer">
	            <button class="btn btn-default" @click="createDictVisible = false">取 消</button>
	            <button class="btn btn-info" @click="newDictSubmit()">确 定</button>
	        </span>
        </ElDialog>
        <!-- 新增文件夹Modal End-->
	</div>
</template>

<script>
	import Media from '../../../components/dashboard/Media.vue'
	import ElDialog from '../../../packages/dialog'

	export default {
		components: {
			Media,
			ElDialog
		},
		data() {
			return {
				crumbs: [
		    		{to: null, text: '媒体库'},
		    	],
		    	//API路由列表
		    	routeList: {
		    		newDictUrl:'/api/media/create',
		    		allDictUrl:'/api/media/folders',
		    		uploadUrl:'/api/media/upload',
		    		delFileUrl:'/api/media/delete',
		    	},
		    	addMediaVisible: false,
		    	createDictVisible: false,
				dictOptions: {},
				selectedDict: [],
				currentDict:'',
				newDictObj: {
					value:'',
					hasError: false,
					errorText: ''
				},

			}
		},
		mounted() {
			let _self = this;
			axios.get(_self.routeList.allDictUrl)
				.then(function (res) {
					_self.dictOptions = res.data;
				})
  				.catch(function (error) {
  					console.log(error);
  				})
		},
		computed: {
			uploadData() {
				return {
					'dict': this.selectedDict
				}
			}
		},
		methods: {
			//文件夹变更
	      	handleChange(value) {

	      	},
	      	//添加媒体对话框关闭时的会掉函数
	      	closeAddMedia() {
	      		this.$refs.mediaUpload.clearFiles();
	      		this.addMediaVisible = false;
	      	},
	      	newDictSubmit() {
	      		let _self = this;
	      		let path = _self.selectedDict.join('/') + '/' +_self.newDictObj.value;
	      		if (_self.newDictObj.value == ''){
	      			_self.newDictObj.hasError = true;
	      			_self.newDictObj.errorText = '文件夹名不能为空';
	      			return false;
	      		}
	      		if (_self.dictIsExist(path)){
	      			_self.newDictObj.hasError = true;
	      			_self.newDictObj.errorText = '该文件夹已存在';
	      			return false; 
	      		}

	      		if (_self.selectedDict.length >= 3){
	      			_self.newDictObj.hasError = true;
	      			_self.newDictObj.errorText = '系统只允许增加三级目录';
	      			return false; 	      			
	      		}

      			_self.newDictObj.hasError = false;
      			axios.post(_self.routeList.newDictUrl, { 'path': path })
      				.then(function (res) {
      					_self.dictOptions = res.data;
      					_self.createDictVisible = false;
      					sweetAlert.success();
      				})
      				.catch(function (error) {
      					console.log(error);
      				});
	      	},
	      	//判断文件夹是否存在，存在返回true
	      	dictIsExist(path) {
	      		let arr = path.split('/');
	      		let dictPath = this.dictOptions;
				for (let i = 0; i < arr.length; i++ ) {
				  	for (let j = 0; j < dictPath.length; j++){
				  		if (arr[i] == dictPath[j]['value']){
				  			if (i == arr.length - 1){
				  				return true;
				  			}
			  				if (dictPath[j].hasOwnProperty('children')){
			  					dictPath = dictPath[j]['children'];
			  					break;
			  				}else{
			  					return false;
			  				}
				  		}
				  	}
				};
				return false;
	      	},
	      	//上传组件中移除文件的回调函数
	      	removeFileInUpload(file, fileList) {
	      		let _self = this;
	      		let filePath = file.response;
      			axios.post(_self.routeList.delFileUrl, { 'path': filePath })
      				.catch(function (error) {
      					console.log(error);
      				});

	      	}
	    }
	}
</script>

<style>
	.el-upload {
		width: 100%;
	}
	.el-upload-dragger{
		width: 100%;
		border-radius: 0px;
	}
	.el-upload__input{
		display: none !important;
	}
	.el-cascader{
		width: 100%;
	}
	.modal-content .block {
	    margin-bottom: 0;
	}
	.el-upload-list__item-name{
		padding-left: 0;
	}
	.media-upload{
		margin-bottom: 20px;
	}
	.text-info{
		display: block;
		margin-bottom: 5px;
	}
	.el-cascader-menus{
		z-index: 3000 !important;
	}
</style>