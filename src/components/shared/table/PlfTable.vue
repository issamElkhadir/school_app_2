<template>
  <div class="card sticky-virtual-scroll-table"
       :class="{ 'rounded': !square, 'rounded-0': square }"
       :style="{ height: toUnit(height), maxHeight: toUnit(maxHeight), minHeight: toUnit(minHeight) }">
    <div v-if="!hideHeader"
         class="card-header p-2 plf-table-top justify-content-between">
      <slot v-if="'top' in $slots"
            name="top" />
      <template v-else>
        <div class="d-flex flex-column w-100 flex-md-row justify-content-between align-items-center">
          <div>
            <slot name="top-left">
              <h3 class="card-title">
                {{ title }}
              </h3>
            </slot>
          </div>

          <div>
            <slot name="top-center" />
          </div>

          <div>

            <slot name="top-right"></slot>
          </div>
        </div>

      </template>
    </div>

    <div class="table-responsive d-flex flex-column flex-fill"
         :class="{ 'rounded-top': !square }">
      <table class="table table-vcenter card-table text-nowrap"
             :class="{ 'table-striped': striped, 'table-sm': dense, 'table-bordered': bordered, 'table-borderless': borderless, 'table-hover': hoverable }">
        <thead v-resizable-column>
          <!--<thead>-->
          <slot name="header"
                :row-key="rowKey"
                :filters="filters"
                :columns="columns">
            <tr ref="colsRow">
              <th v-if="selection !== 'none'"
                  class="w-1">
                <div v-if="selection === 'multiple'">
                  <slot name="header-selection"
                        v-bind="getHeaderScope({})">
                    <PlfCheckbox :model-value="headerSelectedValue"
                                 :square="square"
                                 :indeterminate-value="headerIndeterminate"
                                 class="p-0 align-middle"
                                 @update:modelValue="toggleAllSelection" />
                  </slot>
                </div>
              </th>

              <slot v-for="column in computedVisibleColumns"
                    :key="`column-${column.name}`"
                    :row-key="rowKey"
                    :name="`header-cell`"
                    :filters="filters"
                    :column="column"
                    :columns="columns">
                <PlfTh :column="column"
                       :key="`column-${column.name}`"
                       :filters="filters"
                       :style="column.style"
                       :class="column.classes"
                       @sort="sort">

                  <slot :column="column"
                        :row-key="rowKey"
                        :columns="columns"
                        :filters="filters"
                        :name="`header-cell-${column.name}`">
                  </slot>
                </PlfTh>
              </slot>
            </tr>
          </slot>

          <tr v-if="!('loading' in $slots)">
            <th class="p-0"
                colspan="100%"
                :style="{ top: $refs.colsRow ? $refs.colsRow.offsetHeight + 'px' : '0px' }">
              <div v-if="loading"
                   class="position-relative">
                <div style="height: 2px"
                     class="progress rounded-0 position-absolute progress-separated translate-middle start-50 top-50">
                  <div class="progress-bar progress-bar-indeterminate" />
                </div>
              </div>
            </th>
          </tr>
        </thead>

        <tbody v-if="'top-row' in $slots">
          <slot name="top-row"
                :columns="computedVisibleColumns"></slot>
        </tbody>

        <tbody class="overflow-auto">
          <template v-for="(row, rowIndex) in rows">
            <slot name="body"
                  :row="row"
                  :filters="row.filters"
                  :columns="columns"
                  :row-key="rowKey"
                  :row-index="rowIndex">
              <PlfTr :key="`row-${get(row, rowKey)}`"
                     :row-index="rowIndex"
                     @click="onRowClicked($event, row, rowIndex)"
                     @dblclick="emit('row-dblclick', $event, row, rowIndex)"
                     :row="row"
                     :columns="columns">
                <td v-if="['multiple', 'single'].includes(selection)"
                    key="checkbox"
                    class="w-1">
                  <slot name="body-selection"
                        v-bind="getBodySelectionScope({ key: get(row, rowKey), row, rowIndex })">
                    <PlfCheckbox v-model="selectedMutation"
                                 v-if="selection === 'multiple'"
                                 :square="square"
                                 :value="row[rowKey]"
                                 class="p-0 align-middle" />
                  </slot>
                </td>

                <PlfTd v-for="column in computedVisibleColumns"
                       :key="`${column.name}-${get(row, rowKey)}`"
                       :row-index="rowIndex"
                       :row-key="rowKey"
                       :row="row"
                       :style="column.style"
                       :class="column.classes"
                       :columns="columns"
                       :column="column">
                  <template #default="props">
                    <slot :name="`body-cell-${column.name}`"
                          v-bind="props">
                      {{ columnValue(row, column) }}
                    </slot>
                  </template>
                </PlfTd>
              </PlfTr>
            </slot>
          </template>
        </tbody>

        <tbody v-if="'bottom-row' in $slots">
          <slot name="bottom-row"></slot>
        </tbody>
      </table>

      <div class="d-flex flex-fill justify-content-center align-items-center"
           v-if="isEmpty">
        <slot name="no-data">
          <p class="m-0 p-2 text-muted">
            <PlfIcon name="tblr.IconAlertTriangle" />
            {{ noDataLabel }}
          </p>
        </slot>
      </div>
    </div>

    <div v-if="!hideBottom"
         class="card-footer border-top plf-table-bottom d-flex justify-content-between align-items-center">
      <slot name="bottom">
        <div>
          <slot name="bottom-left" />
        </div>

        <div>
          <slot name="bottom-center" />
        </div>

        <div>
          <slot name="bottom-right">
            <!-- Records per page -->
            <div v-if="pagination && !hidePagination"
                 class="d-flex align-items-center w-100 flex-fill justify-content-start gap-2">

              <div>
                <div class="text-muted align-items-center d-flex gap-2">
                  <span class="d-none d-md-inline">{{ $t(rowsPerPageLabel) }}</span>

                  <select @input="rowsPerPageChanged"
                          class="w-auto form-control form-select-sm">
                    <option v-for="option in rowsPerPageOptions"
                            :key="`row-per-page-${option}`"
                            :selected="option === rowsPerPage"
                            :value="option">
                      <template v-if="option !== 0">
                        {{ option }}
                      </template>
                      <template v-else>
                        All
                      </template>
                    </option>
                  </select>
                  <span class="lh-lg">{{ computedPaginationLabel }}</span>
                </div>
              </div>

              <div>

                <PlfPagination :pagination="pagination"
                               direction-links
                               :page="pagination.page"
                               :rows-per-page="rowsPerPage"
                               :rows-number="pagination.rowsNumber"
                               boundary-links
                               :max-pages="5"
                               @update:page="paginationChanged" />
              </div>
            </div>
          </slot>
        </div>
      </slot>
    </div>

    <slot name="loading"
          :loading="loading" />
  </div>
</template>

<script setup>
import PlfTr from "./PlfTr.js";
import PlfTd from "./PlfTd.js";
import PlfTh from "./PlfTh.vue";
import { computed, ref, unref, watch } from "vue";
import PlfCheckbox from "../checkbox/PlfCheckbox.vue";
import PlfPagination from "../pagination/PlfPagination.vue";
import { get } from 'lodash';
import vResizableColumn from "../../../directives/resizable-column.js";
import { toUnit } from '../../../composables/utils';
import PlfIcon from "../icon/PlfIcon.vue";
const emit = defineEmits(['update:selected', 'update:rowsPerPage', 'request', 'row-clicked', 'row-dblclick']);

const props = defineProps({
  pagination: {
    type: Object,
  },

  loading: Boolean,

  striped: Boolean,

  hideNoData: {
    type: Boolean,
    default: () => false
  },

  hideHeader: {
    type: Boolean,
    default: () => false
  },

  hideBottom: {
    type: Boolean,
    default: () => false
  },

  hidePagination: {
    type: Boolean,
    default: () => false
  },

  bordered: Boolean,

  borderless: Boolean,

  rowsPerPage: {
    type: Number,
    default: 10
  },

  rowsPerPageLabel: {
    type: String,
    default: 'Rows per page:'
  },

  rowsPerPageOptions: {
    type: Array,
    default: () => [5, 7, 10, 15, 20, 25, 50]
  },

  columns: {
    type: Array,
    default: () => []
  },

  rows: {
    type: Array,
    default: () => [],
    required: true,
  },

  noDataLabel: {
    type: String,
    default: () => 'No Data Available'
  },

  paginationLabel: {
    type: Function
  },

  rowKey: {
    type: String,
  },

  title: String,

  selected: {
    type: [Array, String, Number, Object],
    default: () => ([])
  },

  selection: {
    type: String,
    default: () => 'none',
    validator: (value) => {
      return ['single', 'multiple', 'none'].includes(value)
    }
  },

  virtualScrollerOptions: {
    type: Object,
    default: null,
  },

  scrollable: {
    type: Boolean,
    default: false
  },

  scrollHeight: {
    type: String,
    default: null
  },

  // Height in px
  height: {
    type: [String, Number],
    default: 400
  },

  minHeight: {
    type: [String, Number],
    default: 'auto'
  },

  maxHeight: {
    type: [String, Number],
    // default: 'auto'
  },

  visibleColumns: {
    type: Array,
  },

  hoverable: {
    type: Boolean,
    default: true,
  },

  square: {
    type: Boolean,
    default: false,
  },

  dense: {
    type: Boolean,
    default: false,
  },

  filter: {
    type: [String, Object],
    default: null,
  },
});

const selectedMutation = computed({
  get: () => {
    const value = props.selected;

    if (props.selection === 'single' && value) {
      return [value[props.rowKey]];
    }

    return value.map(v => v[props.rowKey]);
  },
  set: (newValue) => {
    emit('update:selected', props.rows.filter(row => newValue.includes(row[props.rowKey])))
  }
});

const isEmpty = computed(() => {
  return props.rows.length === 0 && !props.loading;
})

const rowsPerPageChanged = (evt) => {
  emit('update:rowsPerPage', +evt.target.value);

  // Reset page to 1
  paginationChanged(1, +evt.target.value);
}

const someRowsSelected = computed(() => {
  return props.selected.length > 0
});

const allRowsSelected = computed(() => {
  if (props.selected.length === 0) {
    return false;
  }

  return props.selected.length === props.rows.length;
});

const headerIndeterminate = null;

const headerSelectedValue = computed(() => (
  allRowsSelected.value ? true : someRowsSelected.value ? headerIndeterminate : false
));

const filters = ref({
  pagination: {
    page: props.pagination?.page,
    rowsPerPage: props.rowsPerPage,
  },

  sort: props.pagination?.sort || {},
});

const computedVisibleColumns = computed(() => {
  if (Array.isArray(props.visibleColumns)) {
    return props.columns.filter(c => {
      if (c.toggleable === false) return true;

      return props.visibleColumns.includes(c.name);
    });
  }

  return props.columns;
});

const toggleAllSelection = (newValue) => {
  if (!newValue) {
    selectedMutation.value = [];
    return;
  }

  selectedMutation.value = props.rows.map(row => row[props.rowKey]);
}

const paginationChanged = (page, rowsPerPage = props.rowsPerPage) => {
  filters.value.pagination = {
    page,
    rowsPerPage,
  };

  emit('request', unref(filters));
}

const columnValue = (row, column) => {
  if (column.field) {
    if (typeof column.field === 'function') {
      return column.field(row);
    } else if (column.format && typeof column.format === 'function') {
      return column.format(row);
    } else {
      return get(row, column.field);
    }
  }

  return null;
}

const sort = (column) => {
  if (!column.sortable) return;

  if (!('sort' in filters.value) || filters.value.sort.field !== column.name) {
    filters.value.sort = {
      field: column.name,
      direction: 'asc'
    };
  } else if (filters.value.sort.field === column.name) {
    if (filters.value.sort.direction === 'desc') {
      delete filters.value.sort;
    } else {
      filters.value.sort.direction = 'desc';
    }
  }

  emit('request', unref(filters));
}

const injectProp = (target, propName, get, set) => {
  Object.defineProperty(target, propName, {
    get: get,
    set: set,
    enumerable: true
  });
}

const getBodySelectionScope = (data) => {
  injectProp(data, 'selected', () => {
    return selectedMutation.value.includes(data.key);
  }, (newValue) => {
    if (props.selection === 'none') return;

    if (newValue) {
      if (props.selection === 'single') {
        selectedMutation.value = [data.key];
      } else {
        selectedMutation.value = [...selectedMutation.value, data.key];
      }
    } else {
      selectedMutation.value = selectedMutation.value.filter(key => key !== data.key);
    }
  });

  return data;
}

const getHeaderScope = (data) => {
  injectProp(data, 'selected', () => headerSelectedValue.value, toggleAllSelection);

  return data;
}

const computedPaginationLabel = computed(() => {
  const { page, rowsPerPage, totalRecords } = props.pagination;

  // if page or rowsPerPage or totalRecords is undefined, return an empty string
  if (!page || !rowsPerPage || !totalRecords) {
    return '';
  }

  const start = rowsPerPage * (page - 1) + 1;
  const end = Math.min(totalRecords, rowsPerPage * page);

  const paginationLabel = props.paginationLabel || ((firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex} - ${endRowIndex} of ${totalRowsNumber}`;
  });

  return paginationLabel(start, end, totalRecords);
});

const onRowClicked = ($event, row, rowIndex) => {
  emit('row-clicked', $event, row, rowIndex);

  if (props.selection === 'single') {
    selectedMutation.value = row;
  }
}

watch(() => props.filter, (val) => {
  filters.value.filter = val;

  filters.value.pagination.page = 1;

  emit('request', unref(filters));
}, { deep: true });

watch(() => props.pagination, (val) => {
  if (!val) return;

  filters.value.pagination = { page: val.page, rowsPerPage: val.rowsPerPage };
  filters.value.sort = val.sort || {};
}, { deep: true, immediate: true });
</script>

<style scoped>
.sticky-virtual-scroll-table thead tr th {
  position: sticky;
  z-index: 1;
  box-shadow: 0 1px 0 0 var(--tblr-table-border-color);
  border: none;
  top: 0;
}

.sticky-virtual-scroll-table tbody tr:last-child td {
  border-bottom: none;
}

.theme-dark .sticky-virtual-scroll-table thead tr th {
  background-color: var(--tblr-dark);
}
</style>
