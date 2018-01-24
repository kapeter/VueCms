import Vue from 'vue'
import Message from './message'
import Http from './http'
import VeeValidate from 'vee-validate'
import Validation from './validation' 

Vue.use(Http);
Vue.use(Message);
Vue.use(VeeValidate, Validation);

import { Switch, Radio, RadioGroup, Option,  Tabs, TabPane, Select, Upload, Checkbox, CheckboxGroup } from 'element-ui'
Vue.use(Select)
Vue.use(Option)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Radio)
Vue.use(RadioGroup)
Vue.use(Switch)
Vue.use(Upload)
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
    'vue-media', require('../components/Media.vue')
);
Vue.component(
    'ElDialog', require('../components/dialog/src/component.vue')
);


Vue.directive('permission', {
	inserted (el, binding, vnode) {
		let state = vnode.context.$root.$store.state;
		let {route, handle} = binding.value;
        if (state.theUser.role.is_admin){
            return false;
        }
		for (let i = 0; i < state.permissions.length; i++){
			if (state.permissions[i].route == route){
				if (state.permissions[i]['can_' + handle] != 1){
					el.parentNode.removeChild(el);
					return false;
				}else{
					return false;
				}
			}
		}
		el.parentNode.removeChild(el);
	}
})
