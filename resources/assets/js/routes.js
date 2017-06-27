import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './views/dashboard/Dashboard.vue'
import Parent from './views/dashboard/Parent.vue'

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
                    component: require('./views/dashboard/home/Index.vue')
                },
                {
                    path: 'post',
                    component: Parent,
                    children: [
                        {
                            path: '/',
                            name: 'showPost',
                            component: require(/* webpackChunkName: "post" */ './views/dashboard/post/Index.vue')
                        },
                        {
                            path: 'create',
                            name: 'createPost',
                            component: require(/* webpackChunkName: "post" */ './views/dashboard/post/Create.vue')
                        },
                        {
                            path: ':id/edit',
                            name: 'editPost',
                            component: require(/* webpackChunkName: "post" */ './views/dashboard/post/Edit.vue')
                        }
                    ]
                },
                {
                    path: 'media',
                    component: require('./views/dashboard/media/Index.vue')
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
                            component: require(/* webpackChunkName: "setting" */ './views/dashboard/setting/Category.vue')
                        },
                        {
                            path: 'system',
                            component: require(/* webpackChunkName: "setting" */ './views/dashboard/setting/System.vue')
                        },
                    ]
                },
                {
                    path: 'log',
                    component: require('./views/dashboard/log/Index.vue')
                },
                {
                    path: '*',
                    component: require('./views/dashboard/error/404.vue')
                }
            ]
        }
    ]
})

export default router