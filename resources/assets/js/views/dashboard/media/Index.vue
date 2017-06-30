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
					<div class="pull-right">
						<span class="text-info"><i class="fa fa-exclamation"></i> 双击文件夹或文件进行操作。</span>
					</div>
	     		</div>

	     		<div class="block-content">
					<ul class="folder-crumb">
						<li>当前路径：</li>
						<li v-for="crumb in crumbsArr" @click="turnToFolder(crumb)">
							<a href="javascript:;">{{ crumb }}</a>
						</li>
					</ul>
					<div class="file-body" id="file-body">
						<ul class="media-content">
							<li v-if="!isRoot" @dblclick="goBack()">
								<div class="file-box">
									<div class="file-icon">
										<i class="fa fa-reply"></i>
									</div>
									<div class="file-text">
										<h5>返回上一级</h5>
										<span class="file-opera">..</span>
									</div>
								</div>
							</li>	
							<li v-for="item in currentList" @dblclick.prevent="dbclickEvent(item)">
								<div class="file-box">
									<div class="file-icon">
										<i v-if="item.type == 'text'" class="fa fa-file-text"></i>
										<i v-if="item.type == 'folder'" class="fa fa-folder"></i>
										<img v-if="item.type == 'image'" :src="item.url">
										<i v-if="item.type == 'audio'" class="fa fa-music"></i>
										<i v-if="item.type == 'video'" class="fa fa-video-camera"></i>
									</div>
									<div class="file-text">
										<h5>{{item.name}}</h5>
										<span class="file-opera">
											<a href="#">编辑</a>&nbsp;&nbsp;
											<a href="#">删除</a>&nbsp;&nbsp;
										</span>
									</div>
								</div>
							</li>		
						</ul>
					</div>
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

        <!-- 详细信息Modal -->
        <ElDialog title="详细信息" :visible.sync="detailVisible" size="tiny">
        	<div class="media-detail">
        		<img v-if="activeItem.type == 'image'" :src="activeItem.url">
				<dl>
					<dt>文件名</dt>
					<dd>{{ activeItem.name }}</dd>
					<dt>文件类型</dt>
					<dd>{{ activeItem.type }}</dd>
					<dt v-if="'size' in activeItem">文件大小</dt>
					<dd v-if="'size' in activeItem">{{ activeItem.size }}</dd>
					<dt>引用地址</dt>
					<dd>{{ activeItem.url }}</dd>
					<dt v-if="'lastModified' in activeItem">最近修改</dt>
					<dd v-if="'lastModified' in activeItem">{{ activeItem.lastModified }}</dd>
				</dl>        		
        	</div>
        </ElDialog>
        <!-- 详细信息Modal End-->
	</div>
</template>

<script>
	import ElDialog from '../../../packages/dialog'
	import { Loading } from 'element-ui'

	export default {
		components: {
			ElDialog
		},
		data() {
			return {
				crumbs: [
		    		{to: null, text: '媒体库'},
		    	],
		    	//API路由列表
		    	routeList: {
		    		browseUrl : '/api/media',
		    		newDictUrl: '/api/media/create',
		    		allDictUrl: '/api/media/folders',
		    		uploadUrl : '/api/media/upload',
		    		delFileUrl: '/api/media/delete',
		    	},
		    	addMediaVisible: false,
		    	createDictVisible: false,
				dictOptions: {},
				selectedDict: [],
				currentDict:'public',
				currentList:[],
				crumbsArr: ['public'],
				isRoot: true,
				activeItem:{},
				newDictObj: {
					value:'',
					hasError: false,
					errorText: ''
				},
				detailVisible: false,
			}
		},
		mounted() {
			this.allDicts();
			this.browseList();
		},
		computed: {
			uploadData() {
				return {
					'dict': this.selectedDict
				}
			}
		},
		methods: {
	      	//添加媒体对话框关闭时的回调函数
	      	closeAddMedia() {
	      		this.$refs.mediaUpload.clearFiles();
	      		this.addMediaVisible = false;
	      		this.browseList();
	      	},
	      	//获取文件列表
	      	browseList() {
	      		let loadingInstance = null;
	      		let _self = this;
	      		let url = _self.routeList.browseUrl + "?path=" + _self.currentDict;
	      		let reqInterceptor = axios.interceptors.request.use(function (config) {
	      			loadingInstance = Loading.service({target: document.querySelector('#file-body')});
	      			return config;
	      		});
	      		let resInterceptor = axios.interceptors.response.use(function (response) {
	      			loadingInstance.close();
	      			return response;
	      		});
				axios.get(url)
					.then(function (res) {
						_self.currentList = res.data;
						axios.interceptors.request.eject(reqInterceptor);
						axios.interceptors.response.eject(resInterceptor);
					})
	  				.catch(function (error) {
	  					console.log(error);
	  				})
	      	},
			dbclickEvent(item){
				if (item.type == 'folder'){
					this.currentDict = item.origin;
					this.isRoot = false;
					this.crumbsArr = this.currentDict.split('/');
					this.browseList();
				}else{
					this.activeItem = item;
					this.detailVisible = true;
				}
			},
			goBack(){
				let temp = this.currentDict.split('/');
				temp.pop();
				if (temp.length == 1){
					this.isRoot = true;
					this.currentDict = temp[0];
				}else{
					this.currentDict = temp.join('/');
				}
				this.crumbsArr = temp;
				this.browseList();
			},
			turnToFolder(crumb) {
				for(let i = 0; i<this.crumbsArr.length; i++){
					if (crumb == this.crumbsArr[i]){
						let temp = this.crumbsArr.slice(0,i);
						temp.push(crumb);
						if (temp.length == 1){
							this.isRoot = true;
							this.currentDict = temp[0];
						}else{
							this.currentDict = temp.join('/');
						}
						this.crumbsArr = temp;
						this.browseList();
						break;
					}
				}
			},
	      	//获取所有目录
	      	allDicts() {
	      		let _self = this;
				axios.get(_self.routeList.allDictUrl)
					.then(function (res) {
						_self.dictOptions = res.data;
					})
	  				.catch(function (error) {
	  					console.log(error);
	  				})
	      	},
	      	//新建目录
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
      					_self.browseList();
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
	.folder-crumb {
		padding: 10px 20px;
		margin:-20px -20px 0 -20px;
		background: #f0f3f4;
		list-style: none;
		color: #999;
	}
	.folder-crumb > li {
		float: left;
	}
	.folder-crumb > li::after{
		content: '/';
		padding: 0 10px;
		color: #999;
	}
	.folder-crumb >li:last-child::after{
		content: '';
	}
	.folder-crumb::after{
		clear: both;
		content: '';
		height: 0;
		display: block;
	}
	.file-body{
		position: relative;
		min-height:450px;
	}
	.media-content{
		margin:10px -10px;
		width: 100%;
		display: flex;
		list-style: none;
		padding: 0;
		flex-wrap: wrap;
	}
	.media-content::after{
		content: '';
		display: block;
		height: 0;
		clear: both;
	}
	.media-content > li {
		flex: 1;
		width: 100%;
		min-width: 250px;
		max-width: 250px;
	}
	.file-box{
	    padding: 10px;
	    margin: 10px;
	    cursor: pointer;
	    border-radius: 4px;
	    border: 1px solid #e6e6e6;
	    overflow: hidden;
	    background: #f6f8f9;
	    display: flex;
	    color: #999;
	    transition: all .2s ease-out;
    	user-select:none;
	}
	.file-icon{
		flex: 1;
		font-size: 40px;
	    text-align: center;
	    padding-left: 0px;
	    margin-left: 0px;
	    margin-right: 10px;
	}
	.file-icon > img{
		max-width: 100%;
		max-height: 50px;
	}
	.file-text{
		flex: 2;
	    overflow: hidden;
	    width: 100%;
	}
	.file-text h5 {
	    margin-bottom: 2px;
	    margin-top: 10px;
	    max-height: 17px;
	    height: 17px;
	    overflow: hidden;
	    font-size: 14px;
	    text-overflow: ellipsis;
	}
	.file-text .file-opera > a {
		font-size: 12px;
		color: #999;
	}
	.file-text .file-opera > a:hover{
		text-decoration: underline;
	}
	.file-box:hover{
		color:#fff;
		background: #66ccff;
	}
	.file-box:hover .file-opera > a {
		color: #fff;
	} 
	.media-detail{
		min-height: 80px;
	    color: #646464;
	}
	.media-detail h4 {
		font-size: 18px;
		margin-bottom: 15px;
		color: #66ccff;
	}
	.media-detail img {
		display: block;
		max-width: 100%;
		max-height: 300px;
		margin: 0 auto 15px auto;
	}
	.media-detail dl{
		margin-bottom: 0;
	}
	.media-detail dd {
		margin-bottom: 10px;
		text-indent: 2em;
		word-break: break-word;
	}
</style>