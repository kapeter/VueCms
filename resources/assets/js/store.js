const store = {
	state: {
		isMini : false,
		crumbs : [
			{
				name: '仪表盘',
				link: '/dashboard'
			},
			{
				name: '所有文章',
				link: '/dashboard'
			}
		],
	},
	mutations: {
		sidebarMiniToggle (state) {
	  		state.isMini = !state.isMini;
		},
	}
};

export default store;