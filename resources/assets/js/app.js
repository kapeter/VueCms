
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
import router from './routes.js'
import store from './store.js'
import App from './App.vue'


import { Switch, Radio, RadioGroup, Option, Select, Tabs, TabPane, Upload, Cascader } from 'element-ui'

Vue.use(Select)
Vue.use(Option)
Vue.use(Radio)
Vue.use(RadioGroup)
Vue.use(Switch)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Upload)
Vue.use(Cascader)

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

window.eventBus = new Vue();


new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');