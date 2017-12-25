<template>
	<div>
	    <!-- Page Header -->
	    <div class="content">
	        <div class="row">
	            <div class="col-sm-6 media">
	                <ul class="nav nav-pills">
						<li v-for="crumb in crumbsArr" @click="turnToFolder(crumb)">
							<a href="javascript:void(0)" v-if="crumb == 'public'"><i class="fa fa-fw fa-folder-open-o push-5-r"></i>媒体库</a>
							<a href="javascript:void(0)" v-else><i class="fa fa-fw fa-angle-right"></i>{{ crumb }}</a>
						</li>
	                </ul>
	            </div>
	            <div class="col-sm-6 text-right hidden-xs">
					<ul class="block-button pull-right">
						<li>
							<button class="btn btn-info" @click="addMediaVisible = true">
								<i class="fa fa-cloud-upload"></i> 添加媒体
							</button>
						</li>
						<li>
							<button class="btn btn-info" @click="openNewDict()">
								<i class="fa fa-plus"></i> 新增文件夹
							</button>
						</li>
					</ul>
	            </div>
	        </div>
	    </div>

        <div class="content">
			<div class="row file-body" id="file-body">
				<div class="col-sm-6 col-md-4 col-lg-2" v-if="!isRoot" @click="goBack()">
                    <div class="block block-rounded media-box">
                        <div class="block-header">
                        	<ul class="block-options"></ul>
                        </div>
                        <div class="block-content text-center">
                            <div class="item item-2x item-circle bg-gray-light text-gray">
								<i  class="si si-action-undo"></i>
                            </div>                          
                        </div>
                        <div class="block-content block-content-full text-center mheight-100">
                            <h3 class="h5 font-w300 text-black push-5 no-wrap">返回上一级</h3>
                            <span class="text-gray">.. /</span>

                        </div>
                    </div>
                </div>
				<div class="col-sm-6 col-md-4 col-lg-2" v-for="item in currentList">
                    <div class="block media-box"  @click.prevent="clickBoxEvent(item)">
                        <div class="block-header">
                            <ul class="block-options">
                                <li title="下载" v-if="item.type != 'folder'">
                                    <a :href="routeList.downloadUrl + '?path=' + item.origin"><i class="si si-cloud-download"></i></a>
                                </li>
                                <li title="删除">
                                    <button type="button" @click.stop="deleteFileOrFolder(item)"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="block-content text-center">
                            <div class="item item-2x item-circle bg-success-light text-success" v-if="item.type == 'audio'">
								<i  class="si si-music-tone-alt"></i>
                            </div>
                            <div class="item item-2x item-circle bg-warning-light text-warning" v-if="item.type == 'text'">
								<i  class="si si-book-open"></i>
                            </div>  
                            <div class="item item-2x item-circle bg-danger-light text-danger" v-if="item.type == 'video'">
								<i  class="si si-camcorder"></i>
                            </div> 
                            <div class="item-img" v-if="item.type == 'image'">
                            	<img class="cursor-hover" :src="item.url" :alt="item.name">
                            </div>
                            <div class="item item-2x item-circle bg-info-light text-info" v-if="item.type == 'folder'">
								<i  class="si si-folder-alt"></i>
                            </div>                           
                        </div>
                        <div class="block-content block-content-full text-center mheight-100">
                            <h3 class="h5 font-w300 text-black push-5 no-wrap">{{item.name}}</h3>
                            <span class="text-gray" v-if="item.type == 'folder'">点击图标进入</span>
                            <span class="text-gray" v-else>{{ item.size }}</span>

                        </div>
                    </div>
                </div>
			</div>
        </div>
        <!-- 添加媒体Modal -->
        <ElDialog title="添加媒体" :visible.sync="addMediaVisible" width="36%" :before-close="closeAddMedia">

			<ul class="current-list clearfix">
				<li><strong>当前文件夹：</strong></li>
    			<li v-for="crumb in crumbsArr">
    				<span v-if="crumb == 'public'">媒体库</span>
				    <span v-else>/ {{ crumb }}</span>
				</li>
			</ul>
        	<el-upload
        		ref="mediaUpload"
        		class="media-upload"
			  	drag
			  	:action="routeList.uploadUrl"
			  	:data="uploadData"
			  	:on-remove="removeFileInUpload"
			  	:file-list="fileList"
			  	:http-request="uploadFile"
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
        <ElDialog title="新增文件夹" :visible.sync="createDictVisible" width="36%">
			<ul class="current-list clearfix">
				<li><strong>当前文件夹：</strong></li>
    			<li v-for="crumb in crumbsArr">
    				<span v-if="crumb == 'public'">媒体库</span>
				    <span v-else>/ {{ crumb }}</span>
				</li>
			</ul>
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
        <ElDialog title="详细信息" :visible.sync="detailVisible" width="36%">
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
	import { Loading } from 'element-ui'

	export default {
		data() {
			return {
				crumbs: [
		    		{to: null, text: '媒体库'},
		    	],
		    	//API路由列表
		    	routeList: {
		    		browseUrl    : 'media',
		    		newDictUrl   : 'media/create',
		    		uploadUrl    : 'media/upload',
		    		delFileUrl   : 'media/delete',
		    		downloadUrl  : 'media/download'
		    	},
		    	addMediaVisible: false,
		    	createDictVisible: false,
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
				fileList: []
			}
		},
		mounted() {
			this.browseList();
		},
		computed: {
			uploadData() {
				return {
					'dict': this.currentDict.split('/')
				}
			}
		},
		methods: {
			openNewDict() {
				this.createDictVisible = true;
				this.newDictObj = { value:'', hasError: false, errorText: ''};
			},
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
				_self.$http.get(url)
					.then(function (res) {
						_self.currentList = res.data;
					})
	  				.catch(function (error) {
	  					console.log(error);
	  				})
	      	},
	      	clickBoxEvent(item){
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
			//返回上一级
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
	      	//新建目录
	      	newDictSubmit() {
	      		let _self = this;
	      		_self.newDictObj.hasError = false;
	      		if (_self.newDictObj.value == ''){
	      			_self.newDictObj.hasError = true;
	      			_self.newDictObj.errorText = '文件夹名不能为空';
	      			return false;
	      		}

      			_self.$http.post(_self.routeList.newDictUrl, { 'path': _self.currentDict, 'name': _self.newDictObj.value })
      				.then(function (res) {
      					if ('code' in res.data && res.data.code == 11002) {
	      					_self.newDictObj.hasError = true;
		      				_self.newDictObj.errorText = '该文件夹已存在';
      					}else{
      						_self.createDictVisible = false;
      						_self.browseList();
      					}
      				})
      				.catch(function (error) {
      					console.log(error);
      				});
	      	},

	      	//上传组件中移除文件的回调函数
	      	removeFileInUpload(file, fileList) {
	      		let _self = this;
	      		let filePath = file.response;
      			_self.$http.post(_self.routeList.delFileUrl, { 'origin': filePath, 'type': 'file' })
      				.catch(function (error) {
      					console.log(error);
      				});

	      	},
	      	//删除按钮
	      	deleteFileOrFolder(item) {
				let _self = this;
				let warnText = '您确认删除该文件吗？';
				let url = _self.routeList.delFileUrl;
				if (item.type == 'folder'){	
					warnText = '您确认删除该文件夹以及其中的所有文件吗？';
				}
                _self.$message({
                    title: "危险操作",
                    text: warnText,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d26a5c",
                    confirmButtonText: "删  除",
                    cancelButtonText: "取  消",
                },
                function(isConfirm){
                    if (isConfirm){
		      			_self.$http.post(url, item)
		      				.then(function () {
		      					_self.browseList();
		      				})
		      				.catch(function (error) {
		      					console.log(error);
		      				});
                    }
                }); 
	      	},

	      	uploadFile(option) {
	      		let _self = this;
				let formData = new FormData();

				if (option.data) {
				    Object.keys(option.data).map(key => {
				      	formData.append(key, option.data[key]);
				    });
				}

				formData.append(option.filename, option.file);

	      		_self.$http.post(_self.routeList.uploadUrl, formData);
	      	}
	    }
	}
</script>

<style>
	.current-list{
		list-style: none;
		padding: 0;
		margin-bottom: 15px;
	}
	.current-list li{
		float: left;
		margin-right: 5px;
		font-size: 16px;
		text-transform: uppercase;
	}
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
	.modal-content .block {
	    margin-bottom: 0;
	}
	.el-upload-list__item-name{
		padding-left: 0;
	}
	.media-upload{
		margin-bottom: 20px;
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
	.media .nav-pills{
		font-size: 18px;
	}
	.media .nav-pills > li > a{
		font-weight: normal;
		text-transform: uppercase;
		padding: 0;
		padding-top: 6px;
	}
	.media .nav-pills > li > a:hover,.media .nav-pills > li > a:focus{
		color: #66ccff;
		background-color: transparent;
	}
	.item{
		font-size: 32px;
	}
	.item .si{
		line-height: 100px;
	}
	.content .items-push > div{
		margin-bottom: 20px;
	}
	.item-img{
		width: 100%;
		height: 100px;
		overflow: hidden;
	}
	.item-img img{
		max-width: 100%;
	}
	.no-wrap{
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.media-box{
		border: 1px solid rgba(0,0,0,0);
		transition: all 0.25s ease-out;
		cursor: pointer;
	}
	.media-box:hover{
		border: 1px solid #66ccff;
	}
</style>