import API from '../http'

const setting = {
	state: { 
		systemInfo : [],  //系统信息
	},
  	mutations: {
  		SYSTEM_INFO(state, systemInfo) {
  			state.systemInfo = systemInfo
  		} 
  	},
  	actions: {

  	},
  	getters: {  }
}

export default setting