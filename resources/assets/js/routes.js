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
                    },
                    {
                        path: 'category',
                        component: require('./views/dashboard/post/Category.vue')
                    }
                ]
            },
            {
                path: '*',
                component: require('./views/dashboard/error/404.vue')
            }
        ]
    }
]