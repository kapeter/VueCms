<template>
      <form class="form-inline">
        <div class="form-group">
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="search…">
          <button class="btn btn-info" @click.prevent="doFilter" data-toggle="tooltip" title="搜索"><i class="fa fa-search"></i></button>
          <button class="btn btn-default" @click.prevent="resetFilter" data-toggle="tooltip" title="重置"><i class="fa fa-refresh"></i></button>
        </div>
      </form>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$root.$emit('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$root.$emit('filter-reset')
      }
    }
  }
</script>