import Vue from 'vue'
import VueRouter from 'vue-router'
import Parent from '../views/Parent.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import(/* webpackChunkName: "auth" */ '../views/auth/Login.vue')
        },
        {
            path: '/',
            component: () => import(/* webpackChunkName: "layout" */ '../views/Dashboard.vue'),
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import(/* webpackChunkName: "dashboard" */ '../views/home/Index.vue')
                },
                {
                    path: 'post',
                    component: Parent,
                    children: [
                        {
                            path: '/',
                            name: 'showPost',
                            component: () => import(/* webpackChunkName: "post" */ '../views/post/Index.vue')
                        },
                        {
                            path: 'create',
                            name: 'createPost',
                            component: () => import(/* webpackChunkName: "post" */ '../views/post/Create.vue')
                        },
                        {
                            path: ':id/edit',
                            name: 'editPost',
                            component: () => import(/* webpackChunkName: "post" */ '../views/post/Edit.vue')
                        }
                    ]
                },
                {
                    path: 'media',
                    name: 'media',
                    component: () => import(/* webpackChunkName: "media" */ '../views/media/Index.vue')
                },
                {
                    path: 'profile',
                    name: 'profile',
                    component: () => import(/* webpackChunkName: "auth" */ '../views/profile/Index.vue')
                },
                {
                    path: 'setting',
                    name: 'setting',
                    component: Parent,
                    children: [
                        {
                            path: 'category',
                            name: 'category',
                            component: () => import(/* webpackChunkName: "setting" */ '../views/setting/Category.vue')
                        },
                        {
                            path: 'system',
                            name: 'system',
                            component: () => import(/* webpackChunkName: "setting" */ '../views/setting/System.vue')
                        },
                    ]
                },
                {
                    path: 'rbac',
                    component: Parent,
                    children: [
                        {
                            path: 'user',
                            name: 'user',
                            component: () => import(/* webpackChunkName: "rbac" */ '../views/rbac/User.vue')
                        },
                        {
                            path: 'role',
                            name: 'role',
                            component: () => import(/* webpackChunkName: "rbac" */ '../views/rbac/Role.vue')
                        },
                        {
                            path: 'permission',
                            name: 'permission',
                            component: () => import(/* webpackChunkName: "rbac" */ '../views/rbac/Permission.vue')
                        },
                    ]
                },
                {
                    path: 'log',
                    name: 'log',
                    component: () => import(/* webpackChunkName: "log" */  '../views/log/Index.vue')
                },
                {
                    path: 'mail',
                    name: 'mail',
                    component: () => import(/* webpackChunkName: "message" */ '../views/message/Inbox.vue')
                },
            ]
        },
        {
            path: '*',
            component: () => import(/* webpackChunkName: "error" */ '../views/error/404.vue')
        }
    ]
})


//路由拦截器
router.beforeEach((to, from, next) => {
    if (router.app.$store.getters.hasToken){
        if (to.path == '/login'){
            next({path : '/'});
        }else{
            if (!router.app.$store.getters.hasUserInfo){
                router.app.$store.dispatch('getUserInfo');
            }
            next();
        }    
    }else{
        if (to.path != '/login'){
            next({path : '/login'}); 
        }else{
            next();
        }
    }
    
})

export default router