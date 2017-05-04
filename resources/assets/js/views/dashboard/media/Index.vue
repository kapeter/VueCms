<template>
	<div>
        <page-heading title="媒体库" subTitle="Media Library" :crumbs="crumbs"></page-heading>
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
					<ul class="block-button">
						<li>
							<button class="btn btn-info">
								<i class="fa fa-cloud-upload"></i> 添加媒体
							</button>
						</li>
						<li>
							<button class="btn btn-info">
								<i class="fa fa-plus"></i> 新增文件夹
							</button>
						</li>
					</ul>
	     		</div>

	     		<div class="block-content">
					<vue-media></vue-media>
			    </div>  		
	     	</div>   
        </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				crumbs: [
		    		{to: null, text: '媒体库'},
		    	],				
			}

		}
	}
</script>

<style>

</style>