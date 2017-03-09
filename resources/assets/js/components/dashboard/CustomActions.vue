<template>
    <div class="custom-actions">
        <button class="btn btn-sm btn-default" @click="itemAction('edit-item', rowData, rowIndex)"><i class="fa fa-pencil"></i></button>
        <button class="btn btn-sm btn-danger" @click="itemAction('delete-item', rowData, rowIndex)"><i class="fa fa-times"></i></button>
    </div>
</template>

<script>
export default {
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        }
    },
    methods: {
        itemAction (action, data, index) {
            if (action == 'delete-item'){
                sweetAlert({
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
                        let deleteUrl = '/api/posts/' + data.id;
                        axios.delete(deleteUrl)
                            .then(function(){
                                sweetAlert({
                                    title: "操作成功",
                                    type: "success",
                                    timer: 1250,
                                    showConfirmButton: false
                                });
                            });
                    }
                });                
            }else{

            }

        }
    }
}
</script>

