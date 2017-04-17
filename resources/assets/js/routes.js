import Dashboard from './views/dashboard/Dashboard.vue'
import Parent from './views/dashboard/Parent.vue'

//post
const showPost = r => require.ensure([], () => r(require('./views/dashboard/post/Index.vue')), 'post')
const createPost = r => require.ensure([], () => r(require('./views/dashboard/post/Create.vue')), 'post')
const editPost = r => require.ensure([], () => r(require('./views/dashboard/post/Edit.vue')), 'post')

const category = r => require.ensure([], () => r(require('./views/dashboard/setting/Category.vue')), 'setting')
const system = r => require.ensure([], () => r(require('./views/dashboard/setting/System.vue')), 'setting')

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
                        component: showPost
                    },
                    {
                        path: 'create',
                        name: 'createPost',
                        component: createPost
                    },
                    {
                        path: ':id/edit',
                        name: 'editPost',
                        meta: {
                            breadcrumb: '编辑文章',
                        },
                        component: editPost
                    }
                ]
            },
            {
                path: 'profile',
                component: require('./views/dashboard/profile/Index.vue')
            },
            {
                path: 'setting',
                component: Parent,
                children: [
                    {
                        path: 'category',
                        name: 'category',
                        component: category
                    },
                    {
                        path: 'system',
                        component: system
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