<template>
	<div>
        <page-heading title="写文章" subTitle="New Article"></page-heading>
        <div class="content">
 			<vue-form
				:fields="fields"
 			>
				<!-- 发布按钮 -->
				<div slot="form-publish">
					<div class="row">
						<div class="col-sm-6">
							<button class="btn btn-default pull-left" @click="formStore()">保存为书稿</button>
						</div>
						<div class="col-sm-6">
							<button class="btn btn-info pull-right" @click.prevent="formPublish()">发 布</button>
						</div>
					</div>
				</div>
				
				<!-- 分类目录 -->
				<div slot="form-category">
					<p>dasssdasdasdas</p>
				</div>

 			</vue-form>
        </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				fields: [
					{
						label: '标题',
						name: 'title',
						type: 'text',
						value: ''
					},
					{
						label: '摘要',
						name: 'decription',
						type: 'textarea',
						rows: 4,
						value: ''
					},
					{
						label: '正文内容',
						name: 'content',
						type: 'editor',
						value: ''
					}
				],
			}
		},
		methods: {
			formPublish() {
				
			}
		}
	}
</script>
