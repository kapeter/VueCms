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
                        component: require('./views/dashboard/post/Index.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/dashboard/post/Create.vue')
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