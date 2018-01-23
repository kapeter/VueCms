import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		apiUrl: {
			profile: 'profile',
			setting: 'setting'
		},
		isMini : false,
		isHideen : false,
		token : null,
		theUser : {},
		theConf : [],
		mediaIsChecked: false,
		checkedMedia: {},
		menus: []
	},
  	getters: {
  		hasToken: state => {
  			state.token = localStorage.getItem('token');
  			return state.token == null ? false : true
  		},
	    hasUserInfo: state => {
	      	return JSON.stringify(state.theUser) != "{}"
	    },
	},
	mutations: {
		sidebarMiniToggle (state) {
	  		state.isMini = !state.isMini;
		},
		sidebarHideenToggle (state) {
			state.isHideen = !state.isHideen;
		},

		setUserInfo (state,user) {
			state.theUser = user; 
		},
		forgetUserInfo(state) {
			state.theUser = {};
			state.theRole = {};
		},

		setToken(state,token) {
			localStorage.setItem("token", token);
			state.token = token;
		},
		forgetToken(state) {
			localStorage.removeItem("token");
			state.token = null;
		},

		changeMediaState(state, mark){
			state.mediaIsChecked = mark;
		},
		changeMediaData(state, data){
			state.checkedMedia = data;
		},

		setConfig(state, data){
			state.theConf = data;
		}

	},
	actions: {
		login({ commit }, { token } ) {
			commit('setToken', token);
		},
		logout({ commit }){
			commit('forgetUserInfo');
			commit('forgetToken');
		},
		changeMedia({ commit }, { mark, data }){
			commit('changeMediaState', mark);
			commit('changeMediaData', data);
		},

		getUserInfo(context) {
	      Vue.http.get(context.state.apiUrl.profile)
	        .then(function (res) {
	          	context.commit('setUserInfo', res.data.data)
	        })                
	        .catch(function (res) {
                console.log(res);
            });			
		},

		config (context) {
	      Vue.http.get(context.state.apiUrl.setting)
	        .then(function (res) {
	        	context.commit('setConfig', res.data.settings)
	        })
	        .catch(function (res) {
                console.log(res);
            });	
	    }

	},
});

export default store
