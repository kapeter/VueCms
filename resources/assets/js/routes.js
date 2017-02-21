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
                    }
                ]
            },
        ]
    }
]