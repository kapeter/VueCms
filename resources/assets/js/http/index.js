import Vue from 'vue'
import axios from 'axios'
import setting from './setting'

const http = axios.create({
});

http.defaults = {
	headers: {
		'X-Requested-With': 'XMLHttpRequest',
		'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
	},
	validateStatus: function (status) {
    	return status <= 500; 
	}
};

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
);

Vue.prototype.$http = http

export default {
    setting : setting
}