export default {
	attributes: {
		email: "邮箱",
		password: "密码",
		pwd: "密码",
		title: "显示名称",
		route: "路由",
		slug: "唯一标识"
	},
	messages: {
		required: (field, args) => { return field + '不能为空' },
		email: () => { return '请填写正确格式的邮箱地址' },
		alpha_num: (field, args) => { return field + '仅支持英文、数字' },
		alpha_dash: (field, args) => { return field + '仅支持英文、数字、横线(-)' },
		alpha: (field, args) => { return field + '仅支持英文' },
	}
}