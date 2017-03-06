<template>
	<div>
        <page-heading title="写文章" subTitle="New Article"></page-heading>
        <div class="content">
        	<div class="row">
        		<div class="col-sm-9">
        		    <div class="block">
			     		<div class="block-content">
			     			<vue-form></vue-form>
					    </div>  		
			     	</div>	
        		</div>
				<div class="col-sm-3">
					<div class="block block-themed">
						<div class="block-header bg-info">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                </li>
                            </ul>
							<h3 class="block-title">发布</h3>
						</div>
						<div class="block-content">
							<p>dasssdasdasdas</p>
						</div>
					</div>
					<div class="block block-bordered">
						<div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                </li>
                            </ul>
							<h3 class="block-title">分类目录</h3>
						</div>
						<div class="block-content">
							<p>dasssdasdasdas</p>
						</div>
					</div>
				</div>  
        	</div>	
        </div>
	</div>
</template>

<script>
export default {
}
</script>
