<template>
  <div :class="['vuetable-pagination-info', infoClass]" v-html="paginationInfo"></div>
</template>

<script>

export default {
    props: {
        infoClass: {
            type: String,
            default() {
                return ''
            }
        },
        infoTemplate: {
            type: String,
            default() {
                return "显示第 {from} 至 {to} 项结果，共 {total} 项"
            }
        },
        noDataTemplate: {
            type: String,
            default() {
                return '无相关数据'
            }
        },
    },
  computed: {
    paginationInfo () {
      if (this.tablePagination == null || this.tablePagination.total == 0) {
        return this.noDataTemplate
      }

      return this.infoTemplate
        .replace('{from}', this.tablePagination.from || 0)
        .replace('{to}', this.tablePagination.to || 0)
        .replace('{total}', this.tablePagination.total || 0)
    },
  },
  data: function() {
    return {
      tablePagination: null
    }
  },
  methods: {
    setPaginationData (tablePagination) {
      this.tablePagination = tablePagination
    },
  },
}
</script>

<style>
  .vuetable-pagination-info{
      margin:28px 0 12px 0;
      white-space: nowrap;
  }
</style>
