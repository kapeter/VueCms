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
            }
        ]
    },

    {
        name : 'Message Interface',
        children: [
            {
                name : '评论管理',
                icon : 'fa fa-comments',
                url  : 'mail',
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
                name : '登录日志',
                icon : 'fa fa-anchor',
                url  : 'log/signin',
            },
            {
                name : '接口日志',
                icon : 'fa fa-bar-chart-o',
                url  : 'log/operation',
            },
        ]
    },

]