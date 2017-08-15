export default [
    {
        name : '仪表盘',
        icon : 'si si-speedometer',
        uri  : '/'
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
    			uri  : '/post'
    		},
    		{
    			name : '写文章',
    			uri  : '/post/create',
    		}
    	]
    },
    {
        name : '媒体库',
        icon : 'si si-camera',
        uri  : '/media',
    },
    {
        name : '个人中心',
        icon : 'si si-user',
        uri  : '/profile',
    },
    {
        name : 'System Interface',
    },
    {
        name : '分类目录',
        icon : 'si si-grid',
        uri  : '/setting/category'
    },

    {
        name : '系统设置',
        icon : 'si si-settings',
        uri  : '/setting/system',
    },

    {
        name : 'RBAC Interface',
    },
    {
        name : '用户管理',
        icon : 'si si-users',
        uri  : '/rbac/user',
    },
    {
        name : '角色管理',
        icon : 'si si-target',
        uri  : '/rbac/role',
    },
    {
        name : '权限管理',
        icon : 'si si-layers',
        uri  : '/rbac/permission',
    },
    {
        name : 'Log Interface',
    },
    {
        name : '接口日志',
        icon : 'si si-notebook',
        uri  : '/log',
    },
]