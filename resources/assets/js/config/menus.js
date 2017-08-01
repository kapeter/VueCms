export default [
    {
        name : '仪表盘',
        icon : 'si si-speedometer',
        uri  : '/dashboard/'
    },
    {
    	name : 'User Interface',
    },
    {
    	name : '文章管理',
    	icon : 'si si-book-open',
        isOpen : false,
    	children : [
    		{
    			name : '文章列表',
    			uri  : '/dashboard/post'
    		},
    		{
    			name : '写文章',
    			uri  : '/dashboard/post/create',
    		}
    	]
    },
    {
        name : '媒体库',
        icon : 'si si-camera',
        uri  : '/dashboard/media',
    },
    // {
    //     name : '回收站',
    //     icon : 'si si-trash',
    //     uri  : '/dashboard/trash',
    // },
    {
        name : 'System Interface',
    },
    {
        name : '分类目录',
        icon : 'si si-grid',
        uri  : '/dashboard/setting/category'
    },
    {
        name : '用户管理',
        icon : 'si si-users',
        uri  : '/dashboard/setting/user',
    },
    {
        name : '系统设置',
        icon : 'si si-settings',
        uri  : '/dashboard/setting/system',
    },
    {
        name : '接口日志',
        icon : 'si si-notebook',
        uri  : '/dashboard/log',
    },
]