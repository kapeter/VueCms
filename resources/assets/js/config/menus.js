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
    	children : [
    		{
    			name : '文章列表',
    			uri  : '/dashboard/post'
    		},
    		{
    			name : '写文章',
    			uri  : '/dashboard/post/create',
    		},
            {
                name : '分类目录',
                uri  : '/dashboard/post/category',
            },
    	]
    },
    {
        name : '媒体库',
        icon : 'si si-book-open',
        children : [
            {
                name : '文章列表',
                uri  : '/dashboard/media'
            },
        ]
    }
]