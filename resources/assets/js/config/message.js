export default {
    install(Vue, option = {}) {
        const message = require('sweetalert/dist/sweetalert.min.js');

        message.success = () => message({ 
            title: "操作成功", 
            type: "success", 
            timer: 1250, 
            showConfirmButton: false
        });

        message.error = () => message({ 
            title: "操作失败", 
            type: "error", 
            timer: 1250, 
            showConfirmButton: false
        });

        message.delete = (callback) => message({
            title: "危险操作",
            text: "您确认删除该项信息吗？",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d26a5c",
            confirmButtonText: "删  除",
            cancelButtonText: "取  消",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function(isConfirm){
            if (isConfirm){
                callback();
            }
        }); 
        // 1.通过 Vue.http 调用
        Vue.message = message
        // 2.通过 this.$http 调用
        Vue.prototype.$message = message
    }
}