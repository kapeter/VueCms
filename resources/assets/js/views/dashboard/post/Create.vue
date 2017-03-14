<template>
	<div>
        <page-heading title="写文章" subTitle="New Article"></page-heading>
        <div class="content">
 			<vue-form ref="vueForm"
 				apiUrl="/api/post"
				action="create"
				:fields="fields"
			>
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
