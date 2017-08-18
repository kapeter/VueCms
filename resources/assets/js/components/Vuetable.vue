<template>
  <table :class="[css.tableClass]">
    <thead>
      <tr>
        <template v-for="tfield in tfields">
          <template v-if="tfield.visible">
            <template v-if="isSpecialField(tfield.name)">
              <th v-if="extractName(tfield.name) == '__checkbox'"
                :class="['vuetable-th-checkbox-'+trackBy, tfield.titleClass]">
                <input type="checkbox" @change="toggleAllCheckboxes(tfield.name, $event)"
                  :checked="checkCheckboxesState(tfield.name)">
              </th>
              <th v-if="extractName(tfield.name) == '__component'"
                  @click="orderBy(tfield, $event)"
                  :class="['vuetable-th-component-'+trackBy, tfield.titleClass, {'sortable': isSortable(tfield)}]">
                  {{ tfield.title || '' }}
                  <i v-if="isInCurrentSortGroup(tfield) && tfield.title"
                     :class="sortIcon(tfield)"
                     :style="{opacity: sortIconOpacity(tfield)}"></i>
              </th>
              <th v-if="extractName(tfield.name) == '__slot'"
                  @click="orderBy(tfield, $event)"
                  :class="['vuetable-th-slot-'+extractArgs(tfield.name), tfield.titleClass, {'sortable': isSortable(tfield)}]">
                  {{ tfield.title || '' }}
                  <i v-if="isInCurrentSortGroup(tfield) && tfield.title"
                     :class="sortIcon(tfield)"
                     :style="{opacity: sortIconOpacity(tfield)}"></i>
              </th>
              <th v-if="extractName(tfield.name) == '__sequence'"
                  :class="['vuetable-th-sequence', tfield.titleClass || '']" v-html="tfield.title || ''">
              </th>
              <th v-if="notIn(extractName(tfield.name), ['__sequence', '__checkbox', '__component', '__slot'])"
                  :class="['vuetable-th-'+tfield.name, tfield.titleClass || '']" v-html="tfield.title || ''">
              </th>
            </template>
            <template v-else>
              <th @click="orderBy(tfield, $event)"
                :id="'_' + tfield.name"
                :class="['vuetable-th-'+tfield.name, tfield.titleClass,  {'sortable': isSortable(tfield)}]">
                {{  getTitle(tfield) }}&nbsp;
                <i v-if="isInCurrentSortGroup(tfield)" :class="sortIcon(tfield)" :style="{opacity: sortIconOpacity(tfield)}"></i>
              </th>
            </template>
          </template>
        </template>
      </tr>
    </thead>
    <tbody v-cloak>
      <template v-for="(item, index) in tableData">
        <tr @dblclick="onRowDoubleClicked(item, $event)" @click="onRowClicked(item, $event)" :render="onRowChanged(item)" :class="onRowClass(item, index)">
          <template v-for="tfield in tfields">
            <template v-if="tfield.visible">
              <template v-if="isSpecialField(tfield.name)">
                <td v-if="extractName(tfield.name) == '__sequence'" :class="['vuetable-sequence', tfield.dataClass]"
                  v-html="tablePagination.from + index">
                </td>
                <td v-if="extractName(tfield.name) == '__handle'" :class="['vuetable-handle', tfield.dataClass]">
                  <i :class="['sort-handle', css.sortHandleIcon]"></i>
                </td>
                <td v-if="extractName(tfield.name) == '__checkbox'" :class="['vuetable-checkboxes', tfield.dataClass]">
                  <input type="checkbox"
                    @change="toggleCheckbox(item, tfield.name, $event)"
                    :checked="rowSelected(item, tfield.name)">
                </td>
                <td v-if="extractName(tfield.name) === '__component'" :class="['vuetable-component', tfield.dataClass]">
                    <component :is="extractArgs(tfield.name)" :row-data="item" :row-index="index"></component>
                </td>
                <td v-if="extractName(tfield.name) === '__slot'" :class="['vuetable-slot', tfield.dataClass]">
                  <slot :name="extractArgs(tfield.name)" :row-data="item" :row-index="index"></slot>
                </td>
              </template>
              <template v-else>
                <td v-if="hasCallback(tfield)" :class="tfield.dataClass"
                  @click="onCellClicked(item, tfield, $event)"
                  @dblclick="onCellDoubleClicked(item, tfield, $event)"
                  v-html="callCallback(tfield, item)"
                >
                </td>
                <td v-else :class="tfield.dataClass"
                  @click="onCellClicked(item, tfield, $event)"
                  @dblclick="onCellDoubleClicked(item, tfield, $event)"
                  v-html="getObjectValue(item, tfield.name, '')"
                >
                </td>
              </template>
            </template>
          </template>
        </tr>
        <template v-if="useDetailRow">
          <transition :name="detailRowTransition">
            <tr v-if="isVisibleDetailRow(item[trackBy])"
              @click="onDetailRowClick(item, $event)"
              :class="[css.detailRowClass]"
            >
              <td :colspan="countVisibleFields">
                <component :is="detailRowComponent" :row-data="item" :row-index="index"></component>
              </td>
            </tr>
          </transition>
        </template>
      </template>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    tfields: {
      type: Array,
      required: true
    },
    loadOnStart: {
      type: Boolean,
      default: true
    },
    apiUrl: {
        type: String,
        default: ''
    },
    dataPath: {
        type: String,
        default: 'data'
    },
    paginationPath: {
        type: [String],
        default: 'meta.pagination'
    },
    queryParams: {
      type: Object,
      default: function() {
        return {
          sort: 'sort',
          page: 'page',
          perPage: 'per_page'
        }
      }
    },
    appendParams: {
      type: Object,
      default: function() {
        return {}
      }
    },
    httpOptions: {
      type: Object,
      default: function() {
        return {}
      }
    },
    perPage: {
        type: Number,
        default: function() {
          return 10
        }
    },
    sortOrder: {
      type: Array,
      default: function() {
        return []
      }
    },
    multiSort: {
      type: Boolean,
      default: function() {
        return false
      }
    },
    /*
     * physical key that will trigger multi-sort option
     * possible values: 'alt', 'ctrl', 'meta', 'shift'
     * 'ctrl' might not work as expected on Mac
     */
    multiSortKey: {
      type: String,
      default: 'alt'
    },
    rowClassCallback: {
      type: String,
      default: ''
    },
    detailRowComponent: {
      type: String,
      default: ''
    },
    detailRowTransition: {
      type: String,
      default: ''
    },
    trackBy: {
      type: String,
      default: 'id'
    },
    css: {
      type: Object,
      default: function() {
        return {
          tableClass: 'table table-striped',
          loadingClass: 'loading',
          ascendingIcon: 'fa fa-sort-asc',
          descendingIcon: 'fa fa-sort-desc',
          sortHandleIcon: 'fa fa-sort',
        }
      }
    },
    silent: {
      type: Boolean,
      default: false
    }
  },
  data: function() {
    return {
      eventPrefix: 'vuetable:',
      tableData: null,
      tablePagination: null,
      currentPage: 1,
      selectedTo: [],
      visibleDetailRows: [],
    }
  },
  created: function() {
    this.normalizeFields()
    if (this.loadOnStart) {
      this.loadData()
    }
  },
  computed: {
    useDetailRow: function() {
      if (this.tableData && this.tableData[0] && typeof this.tableData[0][this.trackBy] === 'undefined') {
        //this.warn('You need to define "detail-row-id" in order for detail-row feature to work!')
        return false
      }

      return this.detailRowComponent !== ''
    },
    countVisibleFields: function() {
      return this.tfields.filter(function(tfield) {
        return tfield.visible
      }).length
    }
  },
  methods: {
    normalizeFields: function() {
      if (typeof(this.tfields) === 'undefined') {
        this.warn('You need to provide "tfields" prop.')
        return
      }

      let self = this
      let obj
      this.tfields.forEach(function(tfield, i) {
        if (typeof (tfield) === 'string') {
          obj = {
            name: tfield,
            title: self.setTitle(tfield),
            titleClass: '',
            dataClass: '',
            callback: null,
            visible: true,
          }
        } else {
          obj = {
            name: tfield.name,
            title: (tfield.title === undefined) ? self.setTitle(tfield.name) : tfield.title,
            sortField: tfield.sortField,
            titleClass: (tfield.titleClass === undefined) ? '' : tfield.titleClass,
            dataClass: (tfield.dataClass === undefined) ? '' : tfield.dataClass,
            callback: (tfield.callback === undefined) ? '' : tfield.callback,
            visible: (tfield.visible === undefined) ? true : tfield.visible,
          }
        }
        Vue.set(self.tfields, i, obj)
      })
    },
    setTitle: function(str) {
      if (this.isSpecialField(str)) {
        return ''
      }

      return this.titleCase(str)
    },
    getTitle: function(tfield) {
      if (typeof tfield.title === 'undefined') {
        return tfield.name.replace('.', ' ')
      }

      return tfield.title
    },
    isSpecialField: function(tfieldName) {
      return tfieldName.slice(0, 2) === '__'
    },
    titleCase: function(str) {
      return str.replace(/\w+/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
      })
    },
    camelCase: function(str, delimiter = '_') {
      let self = this
      return str.split(delimiter).map(function(item) {
        return self.titleCase(item)
      }).join('')
    },
    notIn: function(str, arr) {
      return arr.indexOf(str) === -1
    },
    loadData: function(success = this.loadSuccess, failed = this.loadFailed) {
      this.fireEvent('loading')

      this.httpOptions['params'] = this.getAllQueryParams()

      Vue.http.get(this.apiUrl, this.httpOptions)
        .then(success)
        .catch(failed);
    },
    loadSuccess: function(response) {
      this.fireEvent('load-success', response)

      let body = this.transform(response.data)

      this.tableData = this.getObjectValue(body, this.dataPath, null)

      let myPagination = this.getObjectValue(body, this.paginationPath, null)
      
      if (myPagination === null) {
        this.warn('vuetable: pagination-path "' + this.paginationPath + '" not found. '
          + 'It looks like the data returned from the sever does not have pagination information '
          + 'or you may have set it incorrectly.'
        )
      }else{
        myPagination.last_page = myPagination.total_pages;
        myPagination.from = myPagination.per_page * (myPagination.current_page - 1) + 1;
        if (myPagination.total_pages == myPagination.current_page){
          myPagination.to = myPagination.total;
        }else{
          myPagination.to = myPagination.per_page * myPagination.current_page;
        }
        myPagination.next_page_url = myPagination.links.next;
        myPagination.prev_page_url = myPagination.links.previous;

        this.tablePagination = myPagination;
      }

      this.$nextTick(function() {
        this.fireEvent('pagination-data', this.tablePagination)
        this.fireEvent('loaded')
      })
    },
    loadFailed: function(response) {
      this.fireEvent('load-error', response)
      this.fireEvent('loaded')
    },
    transform: function(data) {
      let func = 'transform'

      if (this.parentFunctionExists(func)) {
          return this.$parent[func].call(this.$parent, data)
      }

      return data
    },
    parentFunctionExists: function(func) {
      return (func !== '' && typeof this.$parent[func] === 'function')
    },
    fireEvent: function(eventName, args) {
      this.$emit(this.eventPrefix + eventName, args)
    },
    warn: function(msg) {
      if (!this.silent) {
        console.warn(msg)
      }
    },
    getAllQueryParams: function() {
      let params = {}
      params[this.queryParams.sort] = this.getSortParam()
      params[this.queryParams.page] = this.currentPage
      params[this.queryParams.perPage] = this.perPage

      for (let x in this.appendParams) {
        params[x] = this.appendParams[x]
      }

      return params
    },
    getSortParam: function() {
      if (!this.sortOrder || this.sortOrder.tfield == '') {
        return ''
      }

      if (typeof this.$parent['getSortParam'] == 'function') {
        return this.$parent['getSortParam'].call(this.$parent, this.sortOrder)
      }

      return this.getDefaultSortParam()
    },
    getDefaultSortParam: function() {
      let result = '';

      for (let i = 0; i < this.sortOrder.length; i++) {
        let tfieldName = (typeof this.sortOrder[i].sortField === 'undefined')
          ? this.sortOrder[i].tfield
          : this.sortOrder[i].sortField;

        result += tfieldName + '|' + this.sortOrder[i].direction + ((i+1) < this.sortOrder.length ? ',' : '');
      }

      return result;
    },
    extractName: function(string) {
      return string.split(':')[0].trim()
    },
    extractArgs: function(string) {
      return string.split(':')[1]
    },
    isSortable: function(tfield) {
      return !(typeof tfield.sortField === 'undefined')
    },
    isInCurrentSortGroup: function(tfield) {
      return this.currentSortOrderPosition(tfield) !== false;
    },
    currentSortOrderPosition: function(tfield) {
      if ( ! this.isSortable(tfield)) {
        return false
      }

      for (let i = 0; i < this.sortOrder.length; i++) {
        if (this.fieldIsInSortOrderPosition(tfield, i)) {
          return i;
        }
      }

      return false;
    },
    fieldIsInSortOrderPosition(tfield, i) {
      return this.sortOrder[i].tfield === tfield.name && this.sortOrder[i].sortField === tfield.sortField
    },
    orderBy: function(tfield, event) {
      if ( ! this.isSortable(tfield)) return

      let key = this.multiSortKey.toLowerCase() + 'Key'

      if (this.multiSort && event[key]) { //adding column to multisort
        this.multiColumnSort(tfield)
      } else {
        //no multisort, or resetting sort
        this.singleColumnSort(tfield)
      }

      this.currentPage = 1    // reset page index
      this.loadData()
    },
    multiColumnSort: function(tfield) {
      let i = this.currentSortOrderPosition(tfield);

      if(i === false) { //this tfield is not in the sort array yet
        this.sortOrder.push({
          tfield: tfield.name,
          sortField: tfield.sortField,
          direction: 'asc'
        });
      } else { //this tfield is in the sort array, now we change its state
        if(this.sortOrder[i].direction === 'asc') {
          // switch direction
          this.sortOrder[i].direction = 'desc'
        } else {
          //remove sort condition
          this.sortOrder.splice(i, 1);
        }
      }
    },
    singleColumnSort: function(tfield) {
      if (this.sortOrder.length === 0) {
        this.clearSortOrder()
      }

      this.sortOrder.splice(1); //removes additional columns

      if (this.fieldIsInSortOrderPosition(tfield, 0)) {
        // change sort direction
        this.sortOrder[0].direction = this.sortOrder[0].direction === 'asc' ? 'desc' : 'asc'
      } else {
        // reset sort direction
        this.sortOrder[0].direction = 'asc'
      }
      this.sortOrder[0].tfield = tfield.name
      this.sortOrder[0].sortField = tfield.sortField
    },
    clearSortOrder: function() {
      this.sortOrder.push({
        tfield: '',
        sortField: '',
        direction: 'asc'
      });
    },
    sortIcon: function(tfield) {
      let cls = {}
      let i = this.currentSortOrderPosition(tfield);

      if (i !== false) {
        if (this.sortOrder[i].direction == 'asc') {
          cls[this.css.ascendingIcon] = true
        } else {
          cls[this.css.descendingIcon] = true
        }
      }

      return cls;
    },
    sortIconOpacity: function(tfield) {
      /*
       * tfields with stronger precedence have darker color
       *
       * if there are few tfields, we go down by 0.3
       * ex. 2 tfields are selected: 1.0, 0.7
       *
       * if there are more we go down evenly on the given spectrum
       * ex. 6 tfields are selected: 1.0, 0.86, 0.72, 0.58, 0.44, 0.3
       */
      let max = 1.0,
          min = 0.3,
          step = 0.3

      let count = this.sortOrder.length;
      let current = this.currentSortOrderPosition(tfield)


      if(max - count * step < min) {
        step = (max - min) / (count-1)
      }

      let opacity = max - current * step

      return opacity
    },
    hasCallback: function(item) {
      return item.callback ? true : false
    },
    callCallback: function(tfield, item) {
      if ( ! this.hasCallback(tfield)) return

      if(typeof(tfield.callback) == 'function') {
       return tfield.callback(this.getObjectValue(item, tfield.name))
      }

      let args = tfield.callback.split('|')
      let func = args.shift()

      if (typeof this.$parent[func] === 'function') {
        let value = this.getObjectValue(item, tfield.name)

        return (args.length > 0)
          ? this.$parent[func].apply(this.$parent, [value].concat(args))
          : this.$parent[func].call(this.$parent, value)
      }

      return null
    },
    getObjectValue: function(object, path, defaultValue) {
      defaultValue = (typeof defaultValue === 'undefined') ? null : defaultValue

      let obj = object
      if (path.trim() != '') {
        let keys = path.split('.')
        keys.forEach(function(key) {
          if (obj !== null && typeof obj[key] !== 'undefined' && obj[key] !== null) {
            obj = obj[key]
          } else {
            obj = defaultValue
            return
          }
        })
      }
      return obj
    },
    toggleCheckbox: function(dataItem, tfieldName, event) {
      let isChecked = event.target.checked
      let idColumn = this.trackBy

      if (dataItem[idColumn] === undefined) {
        this.warn('__checkbox tfield: The "'+this.trackBy+'" tfield does not exist! Make sure the tfield you specify in "track-by" prop does exist.')
        return
      }

      let key = dataItem[idColumn]
      if (isChecked) {
        this.selectId(key)
      } else {
        this.unselectId(key)
      }
      this.$emit('vuetable:checkbox-toggled', isChecked, dataItem)
    },
    selectId: function(key) {
      if ( ! this.isSelectedRow(key)) {
        this.selectedTo.push(key)
      }
    },
    unselectId: function(key) {
      this.selectedTo = this.selectedTo.filter(function(item) {
        return item !== key
      })
    },
    isSelectedRow: function(key) {
      return this.selectedTo.indexOf(key) >= 0
    },
    rowSelected: function(dataItem, tfieldName){
      let idColumn = this.trackBy
      let key = dataItem[idColumn]

      return this.isSelectedRow(key)
    },
    checkCheckboxesState: function(tfieldName) {
      if (! this.tableData) return

      let self = this
      let idColumn = this.trackBy
      let selector = 'th.vuetable-th-checkbox-' + idColumn + ' input[type=checkbox]'
      let els = document.querySelectorAll(selector)

      // count how many checkbox row in the current page has been checked
      let selected = this.tableData.filter(function(item) {
        return self.selectedTo.indexOf(item[idColumn]) >= 0
      })

      // count == 0, clear the checkbox
      if (selected.length <= 0) {
        els.forEach(function(el) {
          el.indeterminate = false
        })
        return false
      }
      // count > 0 and count < perPage, set checkbox state to 'indeterminate'
      else if (selected.length < this.perPage) {
        els.forEach(function(el) {
          el.indeterminate = true
        })
        return true
      }
      // count == perPage, set checkbox state to 'checked'
      else {
        els.forEach(function(el) {
          el.indeterminate = false
        })
        return true
      }
    },
    toggleAllCheckboxes: function(tfieldName, event) {
      let self = this
      let isChecked = event.target.checked
      let idColumn = this.trackBy

      if (isChecked) {
        this.tableData.forEach(function(dataItem) {
          self.selectId(dataItem[idColumn])
        })
      } else {
        this.tableData.forEach(function(dataItem) {
          self.unselectId(dataItem[idColumn])
        })
      }
      this.$emit('vuetable:checkbox-toggled-all', isChecked)
    },
    gotoPreviousPage: function() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.loadData()
      }
    },
    gotoNextPage: function() {
      if (this.currentPage < this.tablePagination.last_page) {
        this.currentPage++
        this.loadData()
      }
    },
    gotoPage: function(page) {
      if (page != this.currentPage && (page > 0 && page <= this.tablePagination.last_page)) {
        this.currentPage = page
        this.loadData()
      }
    },
    isVisibleDetailRow: function(rowId) {
      return this.visibleDetailRows.indexOf( rowId ) >= 0
    },
    showDetailRow: function(rowId) {
      if (!this.isVisibleDetailRow(rowId)) {
        this.visibleDetailRows.push(rowId)
      }
    },
    hideDetailRow: function(rowId) {
      if (this.isVisibleDetailRow(rowId)) {
        this.visibleDetailRows.splice(
          this.visibleDetailRows.indexOf(rowId),
          1
        )
      }
    },
    toggleDetailRow: function(rowId) {
      if (this.isVisibleDetailRow(rowId)) {
        this.hideDetailRow(rowId)
      } else {
        this.showDetailRow(rowId)
      }
    },
    onRowClass: function(dataItem, index) {
      let func = this.rowClassCallback.trim()

      if (func !== '' && typeof this.$parent[func] === 'function') {
          return this.$parent[func].call(this.$parent, dataItem, index)
      }
      return ''
    },
    onRowChanged: function(dataItem) {
      this.fireEvent('row-changed', dataItem)
      return true
    },
    onRowClicked: function(dataItem, event) {
      this.$emit(this.eventPrefix + 'row-clicked', dataItem, event)
      return true
    },
    onRowDoubleClicked: function(dataItem, event) {
      this.$emit(this.eventPrefix + 'row-dblclicked', dataItem, event)
    },
    onDetailRowClick: function(dataItem, event) {
      this.$emit(this.eventPrefix + 'detail-row-clicked', dataItem, event)
    },
    onCellClicked: function(dataItem, tfield, event) {
      this.$emit(this.eventPrefix + 'cell-clicked', dataItem, tfield, event)
    },
    onCellDoubleClicked: function(dataItem, tfield, event) {
      this.$emit(this.eventPrefix + 'cell-dblclicked', dataItem, tfield, event)
    },
    /*
     * API for externals
     */
    changePage: function(page) {
      if (page === 'prev') {
        this.gotoPreviousPage()
      } else if (page === 'next') {
        this.gotoNextPage()
      } else {
        this.gotoPage(page)
      }
    },
    reload: function() {
      this.loadData()
    },
    refresh: function() {
      this.currentPage = 1
      this.loadData()
    },
  }, // end: methods
  watch: {
    'multiSort': function(newVal, oldVal) {
      if (newVal === false && this.sortOrder.length > 1) {
        this.sortOrder.splice(1);
        this.loadData();
      }
    }
  },
}
</script>
