
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
import store from './store'
import router from './router'
import config from './config'
import App from './App.vue'


import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, config.validation);


import { Switch, Radio, RadioGroup, Option, Select, Upload, Cascader, Checkbox, CheckboxGroup} from 'element-ui'
Vue.use(Select)
Vue.use(Option)
Vue.use(Radio)
Vue.use(RadioGroup)
Vue.use(Switch)
Vue.use(Upload)
Vue.use(Cascader)
Vue.use(Checkbox)
Vue.use(CheckboxGroup)

Vue.component(
    'page-heading', require('./components/Heading.vue')
);
Vue.component(
    'vuetable', require('./components/Vuetable.vue')
);
Vue.component(
    'vuetable-pagination', require('./components/VuetablePagination.vue')
);
Vue.component(
    'vuetable-pagination-info', require('./components/VuetablePaginationInfo.vue')
);
Vue.component(
    'filter-bar', require('./components/FilterBar.vue')
);
Vue.component(
    'vue-form', require('./components/Form.vue')
);

window.eventBus = new Vue();


window.VM = new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');