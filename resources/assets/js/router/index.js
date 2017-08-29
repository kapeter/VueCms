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
            component: () => import('../views/auth/Login.vue')
        },
        {
            path: '/',
            component: () => import('../views/Dashboard.vue'),
            children: [
                {
                    path: '/',
                    component: () => import('../views/home/Index.vue')
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
                    component: () => import('../views/media/Index.vue')
                },
                {
                    path: 'profile',
                    component: () => import('../views/profile/Index.vue')
                },
                {
                    path: 'setting',
                    component: Parent,
                    children: [
                        {
                            path: 'category',
                            name: 'category',
                            component: () => import(/* webpackChunkName: "setting" */ '../views/setting/Category.vue')
                        },
                        {
                            path: 'system',
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
                            component: () => import(/* webpackChunkName: "rbac" */ '../views/rbac/User.vue')
                        },
                        {
                            path: 'role',
                            component: () => import(/* webpackChunkName: "rbac" */ '../views/rbac/Role.vue')
                        },
                        {
                            path: 'permission',
                            component: () => import(/* webpackChunkName: "rbac" */ '../views/rbac/Permission.vue')
                        },
                    ]
                },
                {
                    path: 'log',
                    component: () => import('../views/log/Index.vue')
                },

            ]
        },
        {
            path: '*',
            component: () => import('../views/error/404.vue')
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
                router.app.$store.commit('getUserInfo');
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