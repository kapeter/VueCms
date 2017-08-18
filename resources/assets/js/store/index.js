import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		isMini : false,
		token : '',
		theUser : {},
		theRole : {}, 
	},
  	getters: {
  		token: state => {
  			if (!state.token) {
	  			let myCookie = ""+document.cookie+";"; 
				let searchKey = "token=";
				let startOfCookie = myCookie.indexOf(searchKey);
				let endOfCookie, result;
				if(startOfCookie != -1){
					startOfCookie += searchKey.length;
					endOfCookie = myCookie.indexOf(";",startOfCookie);
					result = myCookie.substring(startOfCookie,endOfCookie);
				}
				state.token = result;
  			}
  			return state.token;
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
                    //如果不是管理员，获取权限
                    if (!user.role.is_admin){
                        Vue.http.get('role/' + user.role.id)
                            .then(function(res){
                                state.theRole = res.data;
                            });                        
                    }
                })
                .catch(function (res) {
                    console.log(res);
                }); 
		},
		setToken(state) {
  			let myCookie = ""+document.cookie+";"; 
			let searchKey = "token=";
			let startOfCookie = myCookie.indexOf(searchKey);
			let endOfCookie, result;
			if(startOfCookie != -1){
				startOfCookie += searchKey.length;
				endOfCookie = myCookie.indexOf(";",startOfCookie);
				result = myCookie.substring(startOfCookie,endOfCookie);
			}
			state.token = result;
		},
		logout(state) {
			state.theUser = {};
			state.theRole = {};
			state.token = '';

			let exp = new Date();
			exp.setTime(exp.getTime() - 1);
			document.cookie= "token=;expires="+exp.toGMTString();
		}
	},
	actions: {
		login(context) {
			context.commit('setToken');
			context.commit('getUserInfo');
		}
	},
});

export default store
