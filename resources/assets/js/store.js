const store = {
	state: {
		isMini : false,
		isLoading : true,
	},
	mutations: {
		sidebarMiniToggle (state) {
	  		state.isMini = !state.isMini;
		},
		loadingToggle (state) {
	  		state.isLoading = false;
		},
	}
};

export default store;