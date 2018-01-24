export default [
    {
    	name : 'Function Interface',
        children: [
            {
                name : '文章管理',
                icon : 'fa fa-book',
                url  : 'post'
            },
            {
                name : '媒体库',
                icon : 'fa fa-camera',
                url  : 'media',
            },
            {
                name : '个人中心',
                icon : 'fa fa-user',
                url  : 'profile',
            },
        ]
    },

    {
        name : 'System Interface',
        children: [
            {
                name : '分类目录',
                icon : 'fa fa-cubes',
                url  : 'category'
            },

            {
                name : '系统设置',
                icon : 'fa fa-cogs',
                url  : 'system',
            },            
        ]
    },

    {
        name : 'Message Interface',
        children: [
            {
                name : '邮件管理',
                icon : 'fa fa-envelope',
                url  : 'mail',
            },
        ]
    },

    {
        name : 'RBAC Interface',
        children: [
            {
                name : '用户管理',
                icon : 'fa fa-users',
                url  : 'user',
            },
            {
                name : '角色管理',
                icon : 'fa fa-crosshairs',
                url  : 'role',
            },
            {
                name : '权限管理',
                icon : 'fa fa-key',
                url  : 'permission',
            },            
        ]
    },

    {
        name : 'Log Interface',
        children: [
            {
                name : '接口日志',
                icon : 'fa fa-bar-chart-o',
                url  : 'log',
            },
        ]
    },

]