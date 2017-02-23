const store = {
	state: {
		isMini : false,
	},
	mutations: {
		sidebarMiniToggle (state) {
	  		state.isMini = !state.isMini;
		}
	}
};

export default store;