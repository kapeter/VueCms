import axios from 'axios'
import Config from './config'

export default {
    install(Vue, option = {}) {
        const http = axios.create({
		    baseURL: Config.baseUrl != '' ? Config.baseUrl : 'http://' + window.location.host + '/api/',
		 	headers: {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			},
			validateStatus: function (status) {
		    	return status <= 500; 
			}
        })

		http.interceptors.response.use(
		    response => {
		        return response;
		    },
		    //统一错误响应
		    error => {
		        if (error.response) {
		            switch (error.response.status) {
		                case 401:
		                	window.location.href="/login";
		                	break;
		            }
		        }
		        return Promise.reject(error);
		    }
		)
        // 1.通过 Vue.http 调用
        Vue.http = http
        // 2.通过 this.$http 调用
        Vue.prototype.$http = http
    }
}