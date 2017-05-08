<template>
	<div>
		<ul class="folder-crumb">
			<li>
				<a href="#">媒体库</a>
			</li>
			<li>
				<a href="#">posts</a>
			</li>
			<li>
				<span>cover</span>
			</li>
		</ul>
		<div class="file-body" id="file-body">
			<ul class="media-content">
				<li>
					<div class="file-box" @mouseenter="showFileDetail($event)" @mouseleave="hideFileDetail($event)">
						<div class="file-icon">
							<i class="fa fa-file-text"></i>
						</div>
						<div class="file-text">
							<h5>fileNamefileNamefileNamefileName</h5>
							<span class="file-opera">
								<a href="#">编辑</a>&nbsp;&nbsp;
								<a href="#">删除</a>&nbsp;&nbsp;
							</span>
						</div>
					</div>
				</li>
				<li>
					<div class="file-box" @mouseenter="showFileDetail($event)" @mouseleave="hideFileDetail($event)">
						<div class="file-icon">
							<i class="fa fa-folder"></i>
						</div>
						<div class="file-text">
							<h5>fileNamefileNamefileNamefileName</h5>
							<span class="file-opera">
								<a href="#">编辑</a>&nbsp;&nbsp;
								<a href="#">删除</a>&nbsp;&nbsp;
							</span>
						</div>
					</div>
				</li>
				<li>
					<div class="file-box" @mouseenter="showFileDetail($event)" @mouseleave="hideFileDetail($event)">
						<div class="file-icon">
							<i class="fa fa-music"></i>
						</div>
						<div class="file-text">
							<h5>fileNamefileNamefileNamefileName</h5>
							<span class="file-opera">
								<a href="#">编辑</a>&nbsp;&nbsp;
								<a href="#">删除</a>&nbsp;&nbsp;
							</span>
						</div>
					</div>
				</li>
				<li>
					<div class="file-box" @mouseenter="showFileDetail($event)" @mouseleave="hideFileDetail($event)">
						<div class="file-icon">
							<i class="fa fa-video-camera"></i>
						</div>
						<div class="file-text">
							<h5>fileNamefileNamefileNamefileName</h5>
							<span class="file-opera">
								<a href="#">编辑</a>&nbsp;&nbsp;
								<a href="#">删除</a>&nbsp;&nbsp;
							</span>
						</div>
					</div>
				</li>	
				<li>
					<div class="file-box" @mouseenter="showFileDetail($event)" @mouseleave="hideFileDetail($event)">
						<div class="file-icon">
							<img src="/img/header-bg.jpg">
						</div>
						<div class="file-text">
							<h5>fileNamefileNamefileNamefileName</h5>
							<span class="file-opera">
								<a href="#">编辑</a>&nbsp;&nbsp;
								<a href="#">删除</a>&nbsp;&nbsp;
							</span>
						</div>
					</div>
				</li>
				<li>
					<div class="file-box" @mouseenter="showFileDetail($event)" @mouseleave="hideFileDetail($event)">
						<div class="file-icon">
							<img src="/img/avatar.jpg">
						</div>
						<div class="file-text">
							<h5>fileNamefileNamefileNamefileName</h5>
							<span class="file-opera">
								<a href="#">编辑</a>&nbsp;&nbsp;
								<a href="#">删除</a>&nbsp;&nbsp;
							</span>
						</div>
					</div>
				</li>			
			</ul>
			<div class="media-detail" v-show="detailVisible" :style="detailStyle">
				<h4>详细信息</h4>
				<dl>
					<dt>文件名</dt>
					<dd>fileNamefileNamefileNamefileNamefileNamefileNamefileNamefileNamefileNamefileNamefileNamefileName</dd>
					<dt>文件类型</dt>
					<dd>image/jpeg</dd>
					<dt>文件大小</dt>
					<dd>360 KB</dd>
					<dt>引用地址</dt>
					<dd>/storage/index.jpg</dd>
				</dl>
				<span class="triangle-left" v-if="detailIsRight"></span>
				<span class="triangle-right" v-else></span>
			</div>
		</div>


	</div>
</template>

<script>
	export default {
		data() {
			return {
				detailVisible: false,
				detailStyle: {
					top: '0px',
					left:'0px',
				},
				detailIsRight: true
			}
		},
		methods: {
			showFileDetail(event) {
				if (document.body.clientWidth < 640 ){
					return false;
				}
				let target = event.currentTarget;
				let bodyWidth = document.getElementById('file-body').offsetWidth;
				if (target.offsetLeft + 240 + 375 > bodyWidth){
					this.detailStyle.left = target.offsetLeft - 385 + 'px';
					this.detailIsRight = false;
				}else{
					this.detailStyle.left = target.offsetLeft + 240 + 'px';
					this.detailIsRight = true;
				}
				this.detailStyle.top = target.offsetTop + 'px';
				
				this.detailVisible = true;
			},
			hideFileDetail() {
				this.detailVisible = false;
			}
		}
	}
</script>

<style>
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
	}
	.file-icon{
		flex: 1;
		font-size: 40px;
	    text-align: center;
	    padding-left: 0px;
	    margin-left: 0px;
	    margin-right: 5px;
	}
	.file-icon > img{
		max-width: 100%;
		height: 40px;
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
		position: absolute;
		right: 0;
		top: 0;
		width: 375px;
		min-height: 80px;
		padding: 15px;
		box-sizing: border-box;
	    border: 1px solid #e6e6e6;
	    border-radius: 3px;
	    background: #f6f8f9;
	    z-index: 100;
	    color: #646464;
	}
	.media-detail h4 {
		font-size: 18px;
		margin-bottom: 15px;
		color: #66ccff;
	}
	.detail-img {
		width: 100%;
		margin-bottom: 15px;
	}
	.media-detail .detail-img > img {
		max-width: 100%;
	}
	.media-detail dd {
		margin-bottom: 10px;
		text-indent: 2em;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	.triangle-left,.triangle-right{
		position: absolute;
		top: 30px;
	    width: 0;
	    height: 0;
	    border-top: 8px solid transparent;
	    border-bottom: 8px solid transparent;
	}
	.triangle-left::before,.triangle-right::before {
		content: '';
		display: block;
		position: absolute;
		top: -7px;
	    width: 0;
	    height: 0;
	    border-top: 7px solid transparent;
	    border-bottom: 7px solid transparent;		
	}
	.triangle-left{
		left: -10px;
	    border-right: 10px solid #e6e6e6;
	}
	.triangle-left::before {
		left: 2px;
	    border-right: 9px solid #f6f8f9;
	}
	.triangle-right{
		right: -10px;
	    border-left: 10px solid #e6e6e6;
	}
	.triangle-right::before{
		right: 2px;
	    border-left: 9px solid #f6f8f9;
	}
</style>