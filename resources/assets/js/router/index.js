import Vue from 'vue'
import VueRouter from 'vue-router'
import Parent from '../pages/Parent.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import(/* webpackChunkName: "auth" */ '../pages/auth/Login.vue')
        },
        {
            path: '/',
            component: () => import(/* webpackChunkName: "layout" */ '../layouts/Default.vue'),
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import(/* webpackChunkName: "dashboard" */ '../pages/home/Index.vue')
                },
                {
                    path: 'post',
                    component: Parent,
                    children: [
                        {
                            path: '/',
                            name: 'showPost',
                            component: () => import(/* webpackChunkName: "post" */ '../pages/post/Index.vue')
                        },
                        {
                            path: 'create',
                            name: 'createPost',
                            component: () => import(/* webpackChunkName: "post" */ '../pages/post/Create.vue')
                        },
                        {
                            path: ':id/edit',
                            name: 'editPost',
                            component: () => import(/* webpackChunkName: "post" */ '../pages/post/Edit.vue')
                        }
                    ]
                },
                {
                    path: 'media',
                    name: 'media',
                    component: () => import(/* webpackChunkName: "media" */ '../pages/media/Index.vue')
                },
                {
                    path: 'profile',
                    name: 'profile',
                    component: () => import(/* webpackChunkName: "auth" */ '../pages/profile/Index.vue')
                },
                {
                    path: 'category',
                    name: 'category',
                    component: () => import(/* webpackChunkName: "setting" */ '../pages/setting/Category.vue')
                },
                {
                    path: 'system',
                    name: 'system',
                    component: () => import(/* webpackChunkName: "setting" */ '../pages/setting/System.vue')
                },
                {
                    path: 'user',
                    name: 'user',
                    component: () => import(/* webpackChunkName: "rbac" */ '../pages/rbac/User.vue')
                },
                {
                    path: 'role',
                    name: 'role',
                    component: () => import(/* webpackChunkName: "rbac" */ '../pages/rbac/Role.vue')
                },
                {
                    path: 'permission',
                    name: 'permission',
                    component: () => import(/* webpackChunkName: "rbac" */ '../pages/rbac/Permission.vue')
                },
                {
                    path: 'log',
                    component: Parent,
                    children: [
                        {
                            path: 'operation',
                            name: 'operation',
                            component: () => import(/* webpackChunkName: "log" */  '../pages/log/Operation.vue')
                        },
                        {
                            path: 'signin',
                            name: 'signin',
                            component: () => import(/* webpackChunkName: "log" */ '../pages/log/Signin.vue')
                        }
                    ]
                    
                },
                {
                    path: 'mail',
                    name: 'mail',
                    component: () => import(/* webpackChunkName: "message" */ '../pages/message/Inbox.vue')
                },
                {
                    path: 'comment',
                    name: 'comment',
                    component: () => import(/* webpackChunkName: "message" */ '../pages/message/Comment.vue')
                }
            ]
        },
        {
            path: '*',
            component: () => import(/* webpackChunkName: "error" */ '../pages/error/404.vue')
        }
    ]
})


//路由拦截器
router.beforeEach((to, from, next) => {
    if (to.path == '/login'){
        if (router.app.$store.getters.hasToken){
            next({path : '/'});
        }else{
            next();
        }
    }else{
        if (router.app.$store.getters.hasToken){
            if (!router.app.$store.getters.hasUserInfo){
                router.app.$store.dispatch('getUserInfo').then(() => {
                    next();
                });
            }else{
                next();
            }           
        }else{
            next({path : '/login'}); 
        }
    }
})

export default router