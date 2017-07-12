import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		isMini : false,
		theUser : {},
	},
	mutations: {
		sidebarMiniToggle (state) {
	  		state.isMini = !state.isMini;
		},
	}
});

export default store
