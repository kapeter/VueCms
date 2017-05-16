<template>
	<div>
        <page-heading title="媒体库" subTitle="Media Library" :crumbs="crumbs"></page-heading>
        <div class="content">
	     	<div class="block">
	     		<div class="block-header">
					<ul class="block-button">
						<li>
							<button class="btn btn-info" @click="addMediaVisible = true">
								<i class="fa fa-cloud-upload"></i> 添加媒体
							</button>
						</li>
						<li>
							<button class="btn btn-info" @click="createDictVisible = true">
								<i class="fa fa-plus"></i> 新增文件夹
							</button>
						</li>
					</ul>
	     		</div>

	     		<div class="block-content" style="min-height:350px;">
					<Media></Media>
			    </div>  		
	     	</div>   
        </div>
        <!-- 添加媒体Modal -->
        <ElDialog title="添加媒体" v-model="addMediaVisible" size="tiny">
        	<div class="form-group">
	          	<el-cascader
				    :options="dictOptions"
				    v-model="selectedDict"
				    @change="handleChange"
				    :change-on-select=true
				    placeholder="请选择文件夹">
				</el-cascader>        		
        	</div>

        	<el-upload
			  	class="upload-demo"
			  	drag
			  	action="https://jsonplaceholder.typicode.com/posts/"
			  	multiple>
			  	<i class="el-icon-upload"></i>
			  	<div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
			  	<div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
			</el-upload>
			<span slot="footer">
	            <button class="btn btn-default" @click="addMediaVisible = false">关  闭</button>
	        </span>
        </ElDialog>
        <!-- 添加媒体Modal End-->

        <!-- 新增文件夹Modal -->
        <ElDialog title="新增文件夹" v-model="createDictVisible" size="tiny">
        	<div class="form-group">
	          	<el-cascader
				    :options="dictOptions"
				    v-model="selectedDict"
				    @change="handleChange"
				    :change-on-select=true
				    placeholder="请选择父目录">
				</el-cascader>        		
        	</div>
			<div class="form-group">
				<input type="text" name="newDictName" class="form-control" placeholder="新文件夹名" v-model="newDictName">
			</div>
			<span class="text-info"><i class="fa fa-exclamation"></i> 请以纯数字或英文的方式命名文件夹。</span>
			<span slot="footer">
	            <button class="btn btn-default" @click="createDictVisible = false">取 消</button>
	            <button class="btn btn-info" @click="newDictSubmit()">确 定</button>
	        </span>
        </ElDialog>
        <!-- 新增文件夹Modal End-->
	</div>
</template>

<script>
	import Media from '../../../components/dashboard/Media.vue'
	import ElDialog from '../../../packages/dialog'

	export default {
		components: {
			Media,
			ElDialog
		},
		data() {
			return {
				crumbs: [
		    		{to: null, text: '媒体库'},
		    	],
		    	addMediaVisible: false,
		    	createDictVisible: false,
				dictOptions: [{
				          value: 'zhinan',
				          label: '指南',
				          children: [{
				            value: 'shejiyuanze',
				            label: '设计原则',
				            children: [{
				              value: 'yizhi',
				              label: '一致'
				            }, {
				              value: 'fankui',
				              label: '反馈'
				            }, {
				              value: 'xiaolv',
				              label: '效率'
				            }, {
				              value: 'kekong',
				              label: '可控'
				            }]
				          }, {
				            value: 'daohang',
				            label: '导航',
				            children: [{
				              value: 'cexiangdaohang',
				              label: '侧向导航'
				            }, {
				              value: 'dingbudaohang',
				              label: '顶部导航'
				            }]
				          }]
				        }, {
				          value: 'zujian',
				          label: '组件',
				          children: [{
				            value: 'basic',
				            label: 'Basic',
				            children: [{
				              value: 'layout',
				              label: 'Layout 布局'
				            }, {
				              value: 'color',
				              label: 'Color 色彩'
				            }, {
				              value: 'typography',
				              label: 'Typography 字体'
				            }, {
				              value: 'icon',
				              label: 'Icon 图标'
				            }, {
				              value: 'button',
				              label: 'Button 按钮'
				            }]
				          }, {
				            value: 'form',
				            label: 'Form',
				            children: [{
				              value: 'radio',
				              label: 'Radio 单选框'
				            }, {
				              value: 'checkbox',
				              label: 'Checkbox 多选框'
				            }, {
				              value: 'input',
				              label: 'Input 输入框'
				            }, {
				              value: 'input-number',
				              label: 'InputNumber 计数器'
				            }, {
				              value: 'select',
				              label: 'Select 选择器'
				            }, {
				              value: 'cascader',
				              label: 'Cascader 级联选择器'
				            }, {
				              value: 'switch',
				              label: 'Switch 开关'
				            }, {
				              value: 'slider',
				              label: 'Slider 滑块'
				            }, {
				              value: 'time-picker',
				              label: 'TimePicker 时间选择器'
				            }, {
				              value: 'date-picker',
				              label: 'DatePicker 日期选择器'
				            }, {
				              value: 'datetime-picker',
				              label: 'DateTimePicker 日期时间选择器'
				            }, {
				              value: 'upload',
				              label: 'Upload 上传'
				            }, {
				              value: 'rate',
				              label: 'Rate 评分'
				            }, {
				              value: 'form',
				              label: 'Form 表单'
				            }]
				          }, {
				            value: 'data',
				            label: 'Data',
				            children: [{
				              value: 'table',
				              label: 'Table 表格'
				            }, {
				              value: 'tag',
				              label: 'Tag 标签'
				            }, {
				              value: 'progress',
				              label: 'Progress 进度条'
				            }, {
				              value: 'tree',
				              label: 'Tree 树形控件'
				            }, {
				              value: 'pagination',
				              label: 'Pagination 分页'
				            }, {
				              value: 'badge',
				              label: 'Badge 标记'
				            }]
				          }, {
				            value: 'notice',
				            label: 'Notice',
				            children: [{
				              value: 'alert',
				              label: 'Alert 警告'
				            }, {
				              value: 'loading',
				              label: 'Loading 加载'
				            }, {
				              value: 'message',
				              label: 'Message 消息提示'
				            }, {
				              value: 'message-box',
				              label: 'MessageBox 弹框'
				            }, {
				              value: 'notification',
				              label: 'Notification 通知'
				            }]
				          }, {
				            value: 'navigation',
				            label: 'Navigation',
				            children: [{
				              value: 'menu',
				              label: 'NavMenu 导航菜单'
				            }, {
				              value: 'tabs',
				              label: 'Tabs 标签页'
				            }, {
				              value: 'breadcrumb',
				              label: 'Breadcrumb 面包屑'
				            }, {
				              value: 'dropdown',
				              label: 'Dropdown 下拉菜单'
				            }, {
				              value: 'steps',
				              label: 'Steps 步骤条'
				            }]
				          }, {
				            value: 'others',
				            label: 'Others',
				            children: [{
				              value: 'dialog',
				              label: 'Dialog 对话框'
				            }, {
				              value: 'tooltip',
				              label: 'Tooltip 文字提示'
				            }, {
				              value: 'popover',
				              label: 'Popover 弹出框'
				            }, {
				              value: 'card',
				              label: 'Card 卡片'
				            }, {
				              value: 'carousel',
				              label: 'Carousel 走马灯'
				            }, {
				              value: 'collapse',
				              label: 'Collapse 折叠面板'
				            }]
				          }]
				        }, {
				          value: 'ziyuan',
				          label: '资源',
				          children: [{
				            value: 'axure',
				            label: 'Axure Components'
				          }, {
				            value: 'sketch',
				            label: 'Sketch Templates'
				          }, {
				            value: 'jiaohu',
				            label: '组件交互文档'
				          }]
				        }],
				selectedDict: [],
				newDictName: '',
			}
		},
		methods: {
	      	handleChange(value) {
	        	console.log(this.selectedDict);
	      	},
	      	newDictSubmit() {
	      		
	      	} 
	    }
	}
</script>

<style>
	.el-upload {
		width: 100%;
	}
	.el-upload-dragger{
		width: 100%;
		border-radius: 0px;
	}
	.el-upload__input{
		display: none !important;
	}
	.el-cascader{
		width: 100%;
	}
	.modal-content .block {
	    margin-bottom: 0;
	}
	.el-upload-list__item-name{
		padding-left: 0;
	}
</style>