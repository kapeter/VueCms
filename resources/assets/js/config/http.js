import axios from 'axios'
import Config from './config'

export default {
    install(Vue, option = {}) {
        const http = axios.create({
		    baseURL: Config.baseUrl != '' ? Config.baseUrl : 'http://' + window.location.host + '/api/',
		 // 	headers: {
			// 	'Content-Type': 'application/x-www-form-urlencoded',
			// },
			validateStatus: function (status) {
		    	return status <= 405; 
			}
        })

        //请求拦截器
		http.interceptors.request.use(
			config => {
				config.headers = {
					'Authorization': 'Bearer ' + localStorage.getItem('token')
				};
			    return config;
			}, 
			error => {
		    	return Promise.reject(error);
			}
		);


        //响应拦截器
		http.interceptors.response.use(
		    response => {
	            switch (response.status) {
	                case 401:
	                	localStorage.removeItem('token');
	                	window.location.href="/login";
	                	break;
	                case 400:
	                	localStorage.removeItem('token');
	                	window.location.href="/login";
	                	break;
	                case 405:
	                	return Promise.reject();
	                	break;
	                default:
	                	let token = response.headers.authorization; 
	                	if (typeof(token) != 'undefined'){
	                		localStorage.setItem('token', token.slice(7));
	                	}
	                	break;
	            }
		        return response;
		    },
		    //统一错误响应
		    error => {
		        return Promise.reject(error);
		    }
		)
        // 1.通过 Vue.http 调用
        Vue.http = http
        // 2.通过 this.$http 调用
        Vue.prototype.$http = http
    }
}