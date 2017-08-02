export default [
    {
        name : '仪表盘',
        icon : 'si si-speedometer',
        uri  : '/dashboard/'
    },
    {
    	name : 'Function Interface',
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
    {
        name : '个人中心',
        icon : 'si si-user',
        uri  : '/dashboard/profile',
    },
    {
        name : 'System Interface',
    },
    {
        name : '分类目录',
        icon : 'si si-grid',
        uri  : '/dashboard/setting/category'
    },

    {
        name : '系统设置',
        icon : 'si si-settings',
        uri  : '/dashboard/setting/system',
    },

    {
        name : 'RBAC Interface',
    },
    {
        name : '用户管理',
        icon : 'si si-users',
        uri  : '/dashboard/rbac/user',
    },
    {
        name : '角色管理',
        icon : 'si si-target',
        uri  : '/dashboard/rbac/role',
    },
    {
        name : '权限管理',
        icon : 'si si-layers',
        uri  : '/dashboard/rbac/permission',
    },
    {
        name : 'Log Interface',
    },
    {
        name : '接口日志',
        icon : 'si si-notebook',
        uri  : '/dashboard/log',
    },
]