<template>
      <form class="form-inline">
        <div class="form-group">
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter">
          <button class="btn btn-info" @click.prevent="doFilter"><i class="si si-magnifier"></i></button>
          <button class="btn btn-default" @click.prevent="resetFilter"><i class="si si-refresh"></i></button>
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
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>