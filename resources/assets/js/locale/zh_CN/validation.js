export default {
	attributes: {
		email: "邮箱",
		password: "密码",
		title: "显示名称",
		route: "路由"
	},
	messages: {
		required: (field, args) => { return field + '不能为空' },
		email: () => { return '请填写正确格式的邮箱地址' },
	}
}