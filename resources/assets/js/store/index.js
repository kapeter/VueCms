import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		isMini : false,
		token : null,
		theUser : {},
		mediaIsChecked: false,
		checkedMedia: {},
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
		// 获取当前用户信息
		getUserInfo (state) {
            Vue.http.get('profile')
                .then(function (res) {
                    let user = res.data.data;
                    state.theUser = user;
                })
                .catch(function (res) {
                    console.log(res);
                }); 
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
		}
	},
});

export default store
