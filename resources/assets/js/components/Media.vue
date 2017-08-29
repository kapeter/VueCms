<template>
	<div class="row file-body" id="file-body">
		<div class="col-sm-4 col-md-3 col-lg-2" v-if="!isRoot" @click="goBack()">
            <div class="thumbnail-box text-center">
                <div class="item text-gray">
					<i  class="si si-action-undo"></i>
                </div>                          
                <div class="block-content text-center">
                    <h3 class="h5 font-w300 text-black push-5 no-wrap">返回上一级</h3>
                </div>
            </div>
        </div>
		<div class="col-sm-4 col-md-3 col-lg-2" v-for="item in currentList">
            <div class="thumbnail-box text-center" @click.prevent="clickBoxEvent(item)">
                <div class="item text-success" v-if="item.type == 'audio'">
					<i  class="si si-music-tone-alt"></i>
                </div>
                <div class="item text-warning" v-if="item.type == 'text'">
					<i  class="si si-book-open"></i>
                </div>  
                <div class="item text-danger" v-if="item.type == 'video'">
					<i  class="si si-camcorder"></i>
                </div> 
                <div class="thumbnail-img" v-if="item.type == 'image'">
                    <div class="img-center">
                        <img class="cursor-hover" :src="item.url" :alt="item.name">
                    </div>
                </div>
                <div class="item text-info" v-if="item.type == 'folder'">
					<i  class="si si-folder-alt"></i>
                </div>                           
                <div class="block-content text-center" v-if="item.type != 'image'" >
                    <h3 class="h5 font-w300 text-black push-5 no-wrap">{{item.name}}</h3>
                    <span v-if="item.type == 'folder'">点击图标进入</span>
                    <span v-else>{{ item.size }}</span>
                </div>
            </div>
        </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
		    	//API路由列表
		    	routeList: {
		    		browseUrl    : 'media',
		    		newDictUrl   : 'media/create',
		    		allDictUrl   : 'media/folders',
		    		uploadUrl    : 'media/upload',
		    		delFileUrl   : 'media/delete',
		    		downloadUrl  : 'media/download'
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
            this.browseList();
        },
        methods: {
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
            enterFolder(item){
                this.currentDict = item.origin;
                this.isRoot = false;
                this.crumbsArr = this.currentDict.split('/');
                this.browseList();
            },       
            clickBoxEvent(item){
                if (item.type == 'folder'){
                    this.enterFolder(item);
                }
            }
        }
		
	}

</script>


<style>
    .thumbnail-box .item{
        font-size: 42px;
    }
    .thumbnail-img{
        position:relative;
        width:100%;
        height:0;
        padding-top:100%;
        overflow: hidden;
    }
    .img-center{
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
    }
    .thumbnail-box:hover{
        border: 1px solid #66ccff;
        box-shadow: inset 0 0 15px rgba(102,204,255,.1), inset 0 0 0 1px rgba(102,204,255,.05);
    }

</style>