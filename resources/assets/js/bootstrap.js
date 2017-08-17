
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/*axios setting*/

window.axios = require('axios');

window.axios.defaults = {
	headers: {
		'X-Requested-With': 'XMLHttpRequest',
		'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
	},
	validateStatus: function (status) {
    	return status <= 500; 
	}
};

window.axios.interceptors.response.use(
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

/*import sweetAlert*/

window.sweetAlert = require('sweetalert/dist/sweetalert.min.js');
window.sweetAlert.success = () => sweetAlert({ title: "操作成功", type: "success", timer: 1250, showConfirmButton: false});
window.sweetAlert.error = () => sweetAlert({ title: "操作失败", type: "error", timer: 1250, showConfirmButton: false});



