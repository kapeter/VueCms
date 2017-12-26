<template>
    <div class="row" @click.self="isChecked = false">
        <div class="col-md-8 col-lg-9 thumbnail-body" :style="{ 'height' : maxHeight + 'px' }" @click.self="isChecked = false">
            <div class="col-8" v-if="!isRoot" @click="goBack()">
                <div class="thumbnail-box">
                    <div class="file-center text-center">
                        <div class="thumbnail-text">
                            <div class="text-gray">
                                <i  class="si si-action-undo"></i>
                            </div>   
                            <h3 class="h5 font-w300 push-5 no-wrap">返回</h3>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8" v-for="item in currentList">
                <div class="thumbnail-box" @click.prevent="clickBoxEvent(item)">
                    <div class="checked-mask" v-show='isChecked && activeItem.origin == item.origin'>
                        <i class="si si-check"></i>
                    </div>
                    <div class="file-center text-center" v-if="item.type != 'image'">
                        <div class="thumbnail-text">
                            <div class="text-success" v-if="item.type == 'audio'">
                                <i  class="si si-music-tone-alt"></i>
                            </div>
                            <div class="text-warning" v-if="item.type == 'text'">
                                <i  class="si si-book-open"></i>
                            </div>  
                            <div class="text-danger" v-if="item.type == 'video'">
                                <i  class="si si-camcorder"></i>
                            </div>        
                            <div class="text-info" v-if="item.type == 'folder'">
                                <i  class="si si-folder-alt"></i>
                            </div>   
                            <h3 class="h5 font-w300 push-5 no-wrap">{{item.name}}</h3>                        
                        </div>
                    </div>
                    <div class="img-center" v-else>
                        <img class="cursor-hover" :src="item.url" :alt="item.name">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3" @click.self="isChecked = false">
            <div class="thumbnail-detail" v-show="isChecked">
                <h4>文件详情</h4>
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
            <div class="thumbnail-detail" v-show="!isChecked">
                <h4>上传文件</h4>
                <ul class="current-list clearfix">
                    <li><strong>当前文件夹：</strong></li>
                    <li v-for="crumb in crumbsArr">
                        <span v-if="crumb == 'public'">媒体库</span>
                        <span v-else>/ {{ crumb }}</span>
                    </li>
                </ul>
                <div>
                    <el-upload
                        ref="mediaUpload"
                        class="media-upload"
                        drag
                        :action="routeList.uploadUrl"
                        :data="uploadData"
                        :on-remove="handleRemove"
                        :http-request="handleRequest"
                        multiple>
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                        <div class="el-upload__tip" slot="tip">支持jpg、png、gif、mp3的文件格式，大小不超过2MB</div>
                    </el-upload>
                </div>                
            </div>

        </div>
    </div>
</template>

<script>
	export default {
        props: {
            isClosed: Boolean,
        },
		data() {
			return {
		    	//API路由列表
		    	routeList: {
		    		browseUrl    : 'media',
		    		uploadUrl    : 'media/upload',
		    		delFileUrl   : 'media/delete',
		    	},
				currentDict:'public',
				currentList:[],
				crumbsArr: ['public'],
				isRoot: true,
				activeItem:{},
				isChecked: false,
			}
		},
        computed: {
            uploadData() {
                return {
                    'dict': this.currentDict.split('/')
                }
            },
            maxHeight() {
                return window.innerHeight * 0.9 - 100;
            }
        },
        mounted() {
            this.browseList();
        },
        beforeDestroy() {
            this.isChecked = false;
        },
        watch: {
            isClosed(val, oldVal) {
                if (val) {
                    this.isChecked = false;
                    this.activeItem = {};
                    this.$store.dispatch('changeMedia',{
                        'mark': this.isChecked,
                        'data': this.activeItem
                    });
                }
            },
        },
        methods: {
            //获取文件列表
            browseList() {
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
                this.isChecked = false;
                this.$store.dispatch('changeMedia',{
                    'mark': this.isChecked,
                    'data': this.activeItem
                });
            },    
            enterFolder(item){
                this.currentDict = item.origin;
                this.isRoot = false;
                this.crumbsArr = this.currentDict.split('/');
                this.browseList();
                this.isChecked = false;
                this.$store.dispatch('changeMedia',{
                    'mark': this.isChecked,
                    'data': this.activeItem
                });
            },       
            clickBoxEvent(item){
                if (item.type == 'folder'){
                    this.enterFolder(item);
                }else{
                    if (this.isChecked && this.activeItem.origin == item.origin){
                        this.isChecked = !this.isChecked;
                    }else{
                        this.isChecked = true;
                        this.activeItem = item;
                    }
                    this.$store.dispatch('changeMedia',{
                        'mark': this.isChecked,
                        'data': this.activeItem
                    });
                }
            },
            handleRequest(option) {
                let _self = this;
                let formData = new FormData();

                if (option.data) {
                    Object.keys(option.data).map(key => {
                        formData.append(key, option.data[key]);
                    });
                }

                formData.append(option.filename, option.file);

                _self.$http.post(_self.routeList.uploadUrl, formData)
                    .then(function(res) {
                        _self.browseList();
                    });
            },
            //上传组件中移除文件的回调函数
            handleRemove(file, fileList) {
                let _self = this;
                let filePath = file.response;
                _self.$http.post(_self.routeList.delFileUrl, { 'origin': filePath, 'type': 'file' })
                    .then(function(res){
                        _self.browseList();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

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
    .el-cascader-menus{
        z-index: 3000 !important;
    }
    .thumbnail-body {
        margin: -5px;
        overflow: auto;
    }
    .thumbnail-body .col-8 {
        width: 50%;
        float: left;
        min-height: 1px;
        position: relative;
        padding: 5px;
    }
    @media screen and (min-width: 640px){
        .thumbnail-body .col-8 {
            width: 25%;
        }        
    }
    @media screen and (min-width: 1200px){
        .thumbnail-body .col-8 {
            width: 12.5%;
        }        
    }
    .thumbnail-box .file-center{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .thumbnail-box .img-center{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        -webkit-transform: translate(50%,50%);
        -ms-transform: translate(50%,50%);
        transform: translate(50%,50%);        
    }
    .img-center img{
        position: absolute;
        left: 0; 
        top: 0;
        height:100%;
        transform: translate(-50%,-50%);
    }
    .thumbnail-box{
        box-shadow: inset 0 0 15px rgba(0,0,0,.1), inset 0 0 0 1px rgba(0,0,0,.05);
        border: 1px solid rgba(0,0,0,.1);
        background: #f0f3f4;
        cursor: pointer;
        transition: all 0.25s ease-out;
        position:relative;
        width:100%;
        height:0;
        padding-top:100%;
        overflow: hidden;
    }
    .thumbnail-box:hover{
        border: 1px solid #66ccff;
        box-shadow: inset 0 0 15px rgba(102,204,255,.1), inset 0 0 0 1px rgba(102,204,255,.05);
    }
    .thumbnail-text{
        width: 100%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font-size: 2em;
    }
    .thumbnail-detail{
        padding-left: 10px;
    }
    .thumbnail-detail h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #66ccff;
        padding-bottom: 15px;
        border-bottom: 1px solid #ccc;
    }
    .thumbnail-detail img {
        display: block;
        max-width: 100%;
        max-height: 300px;
        margin: 0 auto 15px auto;
    }
    .thumbnail-detail dl{
        margin-bottom: 0;
    }
    .thumbnail-detail dd {
        margin-bottom: 10px;
        word-break: break-word;
    }
    .checked-mask{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(102,204,255,.75);
        text-align: center;
        z-index: 10;
        box-sizing: border-box;
        border: 1px solid #66ccff;
    }
    .checked-mask .si{
        font-size: 2.5em;
        color: #fff;
        left: 50%;
        position: absolute;
        top: 50%;
        transform: translate(-50%,-50%);
    }
</style>