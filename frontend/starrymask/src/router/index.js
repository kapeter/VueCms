import Vue from 'vue'
import Router from 'vue-router'
import Layout from '@/components/Layout.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: Layout,
      children: [
        {
          path: '/',
          component: require('@/pages/Home.vue')
        }
      ]
    }
  ]
})
