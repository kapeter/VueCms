import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './views/Dashboard.vue'
import Parent from './views/Parent.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: [
        {
            path: '/dashboard',
            component: Dashboard,
            children: [
                {
                    path: '/',
                    component: require('./views/home/Index.vue')
                },
                {
                    path: 'post',
                    component: Parent,
                    children: [
                        {
                            path: '/',
                            name: 'showPost',
                            component: require(/* webpackChunkName: "post" */ './views/post/Index.vue')
                        },
                        {
                            path: 'create',
                            name: 'createPost',
                            component: require(/* webpackChunkName: "post" */ './views/post/Create.vue')
                        },
                        {
                            path: ':id/edit',
                            name: 'editPost',
                            component: require(/* webpackChunkName: "post" */ './views/post/Edit.vue')
                        }
                    ]
                },
                {
                    path: 'media',
                    component: require('./views/media/Index.vue')
                },
                {
                    path: 'profile',
                    component: require('./views/profile/Index.vue')
                },
                {
                    path: 'setting',
                    component: Parent,
                    children: [
                        {
                            path: 'category',
                            name: 'category',
                            component: require(/* webpackChunkName: "setting" */ './views/setting/Category.vue')
                        },
                        {
                            path: 'system',
                            component: require(/* webpackChunkName: "setting" */ './views/setting/System.vue')
                        },
                    ]
                },
                {
                    path: 'rbac',
                    component: Parent,
                    children: [
                        {
                            path: 'user',
                            component: require(/* webpackChunkName: "rbac" */ './views/rbac/User.vue')
                        },
                        {
                            path: 'role',
                            component: require(/* webpackChunkName: "rbac" */ './views/rbac/Role.vue')
                        },
                        {
                            path: 'permission',
                            component: require(/* webpackChunkName: "rbac" */ './views/rbac/Permission.vue')
                        },
                    ]
                },
                {
                    path: 'log',
                    component: require('./views/log/Index.vue')
                },
                {
                    path: '*',
                    component: require('./views/error/404.vue')
                }
            ]
        }
    ]
})

export default router