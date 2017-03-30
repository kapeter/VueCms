import Dashboard from './views/dashboard/Dashboard.vue'
import Parent from './views/dashboard/Parent.vue'

export default [
    {
        path: '/dashboard',
        component: Dashboard,
        children: [
            {
                path: '/',
                component: resolve => require(['./views/dashboard/home/Index.vue'], resolve)
            },
            {
                path: 'post',
                component: Parent,
                children: [
                    {
                        path: '/',
                        name: 'showPost',
                        component: resolve => require(['./views/dashboard/post/Index.vue'], resolve) 
                    },
                    {
                        path: 'create',
                        name: 'createPost',
                        component: resolve => require(['./views/dashboard/post/Create.vue'], resolve)
                    },
                    {
                        path: ':id/edit',
                        name: 'editPost',
                        component: resolve => require(['./views/dashboard/post/Edit.vue'], resolve)
                    }
                ]
            },
            {
                path: 'profile',
                component: resolve => require(['./views/dashboard/profile/Index.vue'], resolve)
            },
            {
                path: 'setting',
                component: Parent,
                children: [
                    {
                        path: 'category',
                        component: resolve => require(['./views/dashboard/setting/Category.vue'], resolve) 
                    },
                    {
                        path: 'system',
                        component: resolve => require(['./views/dashboard/setting/System.vue'], resolve)
                    },
                ]
            },
            {
                path: '*',
                component: resolve => require(['./views/dashboard/error/404.vue'], resolve)
            }
        ]
    }
]