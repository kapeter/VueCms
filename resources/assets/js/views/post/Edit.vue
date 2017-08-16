<template>
	<div>
        <page-heading title="编辑文章" subTitle="Edit Article" :crumbs="crumbs"></page-heading>
        <div class="content">
 			<vue-form ref="vueForm"
 				url="post"
				action="edit"
				:formFields="formFields"
			>

 			</vue-form>
        </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
		    	crumbs: [
		    		{to: '/dashboard/post', text: '文章管理'},
		    		{to: null, text: '编辑文章'},
		    	],
				formFields: [
					{
						label: '标题',
						name: 'title',
						type: 'text',
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
						value: 'dasdas',
					},
					{
						label: '摘要',
						name: 'description',
						type: 'textarea',
						rows: 4,
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
