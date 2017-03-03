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
            console.log('custom-actions: ' + action, data.name, index)
        }
    }
}
</script>

