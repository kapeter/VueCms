import Dashboard from './views/dashboard/Dashboard.vue'

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
                path: 'home',
                component: require('./views/dashboard/home/Index.vue')
            },
        ]
    }
]