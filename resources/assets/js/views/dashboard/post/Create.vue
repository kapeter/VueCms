<template>
	<div>
        <page-heading title="写文章" subTitle="New Article"></page-heading>
        <div class="content">
 			<vue-form ref="vueForm"
 				url="post"
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
						required: true,
						error: false,
						value: '',
					},
					{
						label: '摘要',
						name: 'description',
						type: 'textarea',
						required: true,
						error: false,
						value: '',
					},
					{
						label: '正文内容',
						name: 'content',
						type: 'editor',
						required: true,
						error: false,
						value: '',
					},
					{
						label: '固定链接',
						info: '仅支持英文、数字，单词之间用 “-” 连接。如果该项空白，系统会通过有道翻译自动填充',
						name: 'slug',
						type: 'text',
						value: '',
					}
				],
			}
		},
		methods: {
		}
	}
</script>
