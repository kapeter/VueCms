<template>
  <div v-if="tablePagination && tablePagination.last_page > 1" :class="css.wrapperClass">
    <li class="paginate_button" @click="loadPage(1)":class="[isOnFirstPage ? css.disabledClass : '']">
      <a href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
    </li>
    <li class="paginate_button" @click="loadPage('prev')":class="[isOnFirstPage ? css.disabledClass : '']">
      <a href="javascript:;"><i class="fa fa-angle-left"></i></a>
    </li>
    <template v-if="notEnoughPages">
      <template v-for="n in totalPage">
        <li class="paginate_button" @click="loadPage(n)" :class="[isCurrentPage(n) ? css.activeClass : '']">
          <a href="javascript:;" v-html="n"></a>
        </li>
      </template>
    </template>
    <template v-else>
      <template v-for="n in windowSize">
        <li class="paginate_button" @click="loadPage(windowStart+n-1)" :class="[isCurrentPage(windowStart+n-1) ? css.activeClass : '']">
        <a href="javascript:;" v-html="windowStart+n-1"></a>
      </template>
    </template>
    <li class="paginate_button" @click="loadPage('next')" :class="[isOnLastPage ? css.disabledClass : '']">
      <a href="javascript:;"><i class="fa fa-angle-right"></i></a>
    </li>
    <li class="paginate_button" @click="loadPage(totalPage)" :class="[isOnLastPage ? css.disabledClass : '']">
      <a href="javascript:;"><i class="fa fa-angle-double-right"></i></a>
    </li>
  </div>
</template>

<script>
export default {
  props: {
    css: {
      type: Object,
      default () {
        return {
          wrapperClass: 'pagination pull-right',
          activeClass: 'active',
          disabledClass: 'disabled',
          paginationClass: 'ui bottom attached segment grid',
          paginationInfoClass: 'left floated left aligned six wide column',
        }
      }
    },
    icons: {
      type: Object,
      default () {
        return {
          first: 'angle double left icon',
          prev: 'left chevron icon',
          next: 'right chevron icon',
          last: 'angle double right icon',
        }
      }
    },
    onEachSide: {
      type: Number,
      default () {
        return 2
      }
    },
  },
  data: function() {
      return {
        tablePagination: null
      }
  },
  computed: {
    totalPage () {
      return this.tablePagination === null
        ? 0
        : this.tablePagination.last_page
    },
    isOnFirstPage () {
      return this.tablePagination === null
        ? false
        : this.tablePagination.current_page === 1
    },
    isOnLastPage () {
      return this.tablePagination === null
        ? false
        : this.tablePagination.current_page === this.tablePagination.last_page
    },
    notEnoughPages () {
      return this.totalPage < (this.onEachSide * 2) + 4
    },
    windowSize () {
      return this.onEachSide * 2 +1;
    },
    windowStart () {
      if (!this.tablePagination || this.tablePagination.current_page <= this.onEachSide) {
        return 1
      } else if (this.tablePagination.current_page >= (this.totalPage - this.onEachSide)) {
        return this.totalPage - this.onEachSide*2
      }

      return this.tablePagination.current_page - this.onEachSide
    },
  },
  methods: {
    loadPage (page) {
      this.$emit('vuetable-pagination:change-page', page)
    },
    isCurrentPage (page) {
      return page === this.tablePagination.current_page
    },
    setPaginationData (tablePagination) {
      this.tablePagination = tablePagination
    },
  }
}
</script>
