import Vue from 'vue'
import Message from './message'
import Http from './http.js'
import VeeValidate from 'vee-validate'
import validation from './validation' 

Vue.use(Http);
Vue.use(Message);
Vue.use(VeeValidate, validation);

import { Switch, Radio, RadioGroup, Option,  Tabs, TabPane, Select, Upload, Cascader, Checkbox, CheckboxGroup } from 'element-ui'
Vue.use(Select)
Vue.use(Option)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Radio)
Vue.use(RadioGroup)
Vue.use(Switch)
Vue.use(Upload)
Vue.use(Cascader)
Vue.use(Checkbox)
Vue.use(CheckboxGroup)

Vue.component(
    'page-heading', require('../components/Heading.vue')
);
Vue.component(
    'vuetable', require('../components/Vuetable.vue')
);
Vue.component(
    'vuetable-pagination', require('../components/VuetablePagination.vue')
);
Vue.component(
    'vuetable-pagination-info', require('../components/VuetablePaginationInfo.vue')
);
Vue.component(
    'filter-bar', require('../components/FilterBar.vue')
);
Vue.component(
    'vue-form', require('../components/Form.vue')
);