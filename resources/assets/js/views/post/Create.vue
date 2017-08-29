<template>
	<div>
        <page-heading title="写文章" subTitle="New Article" :crumbs="crumbs"></page-heading>
        <div class="content">
 			<vue-form ref="vueForm" url="post" action="create" :formFields="formFields">
 				<div slot="moreBox">
					<div class="block block-themed">
						<div class="block-header bg-info">
							<h3 class="block-title">封面图片</h3>
						</div>
						<div class="block-content text-center">
							<a href="javascript:;" @click="posterDialogVisible = true" style="text-decoration:underline;">添加封面图片</a>				
						</div>
					</div> 
 				</div>
 			</vue-form>
        </div>
        <ElDialog title="封面图片" v-model="posterDialogVisible" size="large">
			<vue-media></vue-media>
		</ElDialog>	
	</div>
</template>

<script>
	export default {
		data() {
			return {
		    	crumbs: [
		    		{to: '/post', text: '文章管理'},
		    		{to: null, text: '写文章'},
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
						label: '固定链接',
						info: '仅支持英文、数字，单词之间用 “-” 连接。如果该项空白，系统会通过有道翻译自动填充',
						name: 'slug',
						type: 'text',
						value: '',
					}
				],
				posterDialogVisible: false,
			}
		},
		methods: {
		}
	}
</script>
