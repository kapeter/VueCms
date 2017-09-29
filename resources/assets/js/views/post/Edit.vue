<template>
	<div>
        <page-heading title="编辑文章" subTitle="Edit Article" :crumbs="crumbs"></page-heading>
        <div class="content">
 			<vue-form ref="vueForm" url="post" action="edit" :formFields="formFields" :moreParams="moreParams">
 				<div slot="moreBox">
					<div class="block block-themed">
						<div class="block-header bg-info">
							<h3 class="block-title">封面图片</h3>
						</div>
						<div class="block-content text-center">
							<div class="poster-img" v-show="moreParams.poster.value">
								<img :src="moreParams.poster.value">
							</div>
							<a href="javascript:;" @click="posterDialogVisible = true">{{ moreParams.poster.value ? '更改' : '添加' }}封面图片</a>
							&nbsp;&nbsp;	
							<a v-show="moreParams.poster.value" href="javascript:;" @click="moreParams.poster.value = null" class="text-danger">删除封面图片</a>			
						</div>
					</div> 
 				</div>
 			</vue-form>
        </div>
        <ElDialog title="封面图片" v-model="posterDialogVisible" size="large">
			<vue-media :isClosed="!posterDialogVisible"></vue-media>
			<span slot="footer">
	            <button class="btn btn-default" @click="posterDialogVisible = false">关  闭</button>
	            <button class="btn btn-info" @click="checkPoster()" :disabled="!$store.state.mediaIsChecked">确定选择</button>
	        </span>
		</ElDialog>	
	</div>
</template>

<script>
	export default {
		data() {
			return {
		    	crumbs: [
		    		{to: '/post', text: '文章管理'},
		    		{to: null, text: '编辑文章'},
		    	],
				formFields: [
					{
						label: '标题',
						name: 'title',
						type: 'text',
						validate: 'required',
						value: '',
					},
					{
						label: '正文内容',
						name: 'content',
						type: 'editor',
						value: '',
						validate: '',
					},
					{
						label: '摘要',
						name: 'description',
						type: 'textarea',
						validate: '',
						value: '',
					},
					{
						label: '固定链接',
						info: '仅支持英文、数字，单词之间用 “-” 连接。如果该项空白，系统会通过有道翻译自动填充',
						name: 'slug',
						type: 'text',
						validate: 'alpha_dash',
						value: null,
					},
					{
						label: '文章推荐位',
						name: 'recommend',
						type: 'checkbox',
						option: ['首页推荐位','次级推荐位'],
						value: [],
					}
				],
				posterDialogVisible: false,
				moreParams:{
					poster: {
						name: 'cover_img',
						value: null
					}
				}
			}
		},
		methods: {
			checkPoster() {
				this.moreParams.poster.value = this.$store.state.checkedMedia.url;
				this.posterDialogVisible = false;
			}
		}
	}
</script>

<style>
	.poster-img{
		width: 100%;
		margin-bottom: 20px;
	}
	.poster-img img{
		width: 100%;
	}
</style>