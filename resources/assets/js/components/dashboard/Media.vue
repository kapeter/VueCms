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
				<a href="#">cover</a>
			</li>
		</ul>
		<div class="media-content">
			<div class="media-detail">
			</div>
		</div>

	</div>
</template>

<script>
	
</script>

<style>
	.folder-crumb {
		padding: 10px 20px;
		margin:-20px -20px 0 -20px;
		background: #f0f3f4;
		list-style: none;
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
	.media-content{
		margin:20px 0;
	}
	.media-detail{
		background: #ccc;
	}
</style>