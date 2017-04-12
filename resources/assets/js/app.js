
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

import routes from './routes.js'
import storeObj from './store.js'
import App from './App.vue'

Vue.use(VueRouter)
Vue.use(Vuex)

Vue.component(
    'page-heading', require('./components/dashboard/Heading.vue')
);
Vue.component(
    'vuetable', require('./components/dashboard/Vuetable.vue')
);
Vue.component(
    'vuetable-pagination', require('./components/dashboard/VuetablePagination.vue')
);
Vue.component(
    'vuetable-pagination-info', require('./components/dashboard/VuetablePaginationInfo.vue')
);
Vue.component(
    'filter-bar', require('./components/dashboard/FilterBar.vue')
);
Vue.component(
    'vue-form', require('./components/dashboard/Form.vue')
);

const store = new Vuex.Store(storeObj);

const router = new VueRouter({
	mode: 'history',
	base: __dirname,
	linkActiveClass: 'active',
	routes: routes
})

router.beforeEach((to, from, next) => {
    console.log(routes[0])
    next();
})

window.eventBus = new Vue();

new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');