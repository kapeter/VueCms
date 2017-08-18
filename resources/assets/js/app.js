import Vue from 'vue'
import config from './config'
import store from './store'
import router from './router'
import App from './App.vue'

window.eventBus = new Vue();

window.Vue = Vue;

window.VM = new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');