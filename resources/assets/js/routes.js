import Dashboard from './views/dashboard/Dashboard.vue'
import Parent from './views/dashboard/Parent.vue'

export default [
    {
        path: '/dashboard',
        component: Dashboard,
        children: [
            {
                path: '/',
                component: require('./views/dashboard/home/Index.vue')
            },
            {
                path: 'post',
                component: Parent,
                children: [
                    {
                        path: '/',
                        name: 'showPost',
                        component: require('./views/dashboard/post/Index.vue')
                    },
                    {
                        path: 'create',
                        name: 'createPost',
                        component: require('./views/dashboard/post/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        name: 'editPost',
                        component: require('./views/dashboard/post/Edit.vue')
                    }
                ]
            },
            {
                path: 'setting',
                component: Parent,
                children: [
                    {
                        path: 'category',
                        component: require('./views/dashboard/setting/Category.vue')
                    },
                    {
                        path: 'system',
                        component: require('./views/dashboard/setting/System.vue')
                    },
                ]
            },
            {
                path: '*',
                component: require('./views/dashboard/error/404.vue')
            }
        ]
    }
]