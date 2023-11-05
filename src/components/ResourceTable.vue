<template>
  <!-- Delete Single Modal -->
  <DeleteModal v-model:visible="confirmDelete"
               :selected-count="1"
               :deleting="destroying"
               @delete="handleConfirmDelete" />

  <!-- Delete Filter Modal -->
  <DeleteModal v-model:visible="confirmDeleteFilter"
               :selected-count="1"
               :deleting="destroyingFilter"
               @delete="handleConfirmDeleteFilter" />

  <!-- Delete Multiple Modal -->
  <DeleteModal v-model:visible="confirmDeleteMultiple"
               :selected-count="selectedRows.length" />

  <ExportModal v-model:visible="showExportModal"
               :columns="exportableColumns"
               :resource="url"
               :search="search"
               :filters="filters"
               :sort="sort" />

  <div class="pb-3 flex-fill d-flex flex-column">
    <PlfTable :columns="columns"
              :loading="loading"
              dense
              :rows="data"
              class="flex-fill"
              selection="multiple"
              v-model:selected="selectedRows"
              row-key="id"
              :title="title"
              :filter="search"
              :pagination="pagination"
              :visible-columns="visibleColumns"
              :rows-per-page="pagination.rowsPerPage"
              @request="handleRequest">

      <template #top-row="{ columns }">
        <tr>
          <td class="shadow-none py-2"></td>
          <template v-for="col in columns"
                    :key="`filter-col-${col.name}`">
            <td class="shadow-none py-2">
              <component v-if="col.filterable"
                         :model-value="filters[col.filterField ?? col.field]"
                         @update:modelValue="updateFilter(col.filterField ?? col.field, $event)"
                         :field="col"
                         :is="filterFields[col.dataType ?? 'string']" />
            </td>
          </template>
        </tr>
      </template>

      <template v-for="(slot, key) in tableSlots"
                #[key]="props"
                :key="key">

        <slot :name="key"
              v-bind="props" />
      </template>

      <template v-for="col in columns"
                #[`body-cell-${col.name}`]="props"
                :key="`body-cell-${col.name}`">

        <slot :name="`body-cell-${col.name}`"
              v-bind="props"
              @delete="handleDelete(props.row)">
          <component v-if="col.dataType && col.dataType in indexFields"
                     :is="indexFields[col.dataType ?? 'string']"
                     :column="props.column"
                     :value="props.value"
                     :record="props.row" />

          <template v-else-if="col.name === 'actions'">
            <slot name="body-cell-actions"
                  v-bind="props"
                  @delete="handleDelete(props.row)">
              <ResourceActions :editable="editable"
                               :row="props.row"
                               :edit-link="editable && editLink(props.row)"
                               :deletable="deletable"
                               @delete="handleDelete">
                <template #prepend="props">
                  <slot name="prepend-actions"
                        v-bind="props" />
                </template>

                <template #append="props">
                  <slot name="append-actions"
                        v-bind="props" />
                </template>

                <template #default="props">
                  <slot name="actions"
                        v-bind="props" />
                </template>
              </ResourceActions>
            </slot>
          </template>
        </slot>
      </template>

      <template #top-right>

        <div class="d-flex gap-2">
          <PlfInput v-model.lazy="search">
            <template #prepend>
              <PlfIcon name="tblr.IconSearch" />
            </template>
          </PlfInput>

          <PlfButton v-if="exportableColumns.length && exportable"
                     icon="mdi.IconCloudDownloadOutline"
                     @click="showExportModal = true"
                     class="btn-action" />

          <!-- User Defined Filters Dropdown -->
          <PlfDropdown hide-arrow>
            <template #default>
              <PlfButton icon="mdi.IconHeartOutline"
                         class="btn-action" />
            </template>

            <template #menu>
              <PlfList v-if="userDefinedFilters.length"
                       itemValue="id"
                       itemTitle="name"
                       mandatory
                       nav
                       class="p-0"
                       select-strategy="single">
                <PlfListItem v-for="filter in userDefinedFilters"
                             :key="`hideable-column-${filter.id}`"
                             :title="filter.name"
                             @click="handleFilterClick(filter)"
                             class="py-1 rounded-0">
                  <template #append>
                    <div>
                      <PlfIcon name="mdi.IconTrash"
                               class="text-danger"
                               @click.stop="handleDeleteFilter(filter)" />
                    </div>
                  </template>
                </PlfListItem>
              </PlfList>

              <div v-else
                   class="text-center fw-bold text-muted py-2">
                {{ $t('No filters defined') }}
              </div>

              <PlfDivider class="my-1" />

              <div class="p-2 d-flex flex-column gap-2">
                <PlfInput v-model="newFilterName"
                          size="sm" />

                <PlfButton @click="handleNewFilterClick"
                           label="Add filter"
                           :loading="storingUserDefinedFilter"
                           :disabled="!newFilterName"
                           class="btn-sm btn-primary" />
              </div>
            </template>
          </PlfDropdown>

          <!-- Toggle Column Visibility Dropdown -->
          <PlfDropdown hide-arrow>
            <template #default>
              <PlfButton icon="mdi.IconMenu"
                         class="btn-action" />
            </template>

            <template #menu>
              <PlfList itemValue="id"
                       itemTitle="label"
                       v-model:selected="visibleColumns"
                       mandatory
                       max-height="200px"
                       class="overflow-auto"
                       select-strategy="multiple">

                <PlfListSubheader :title="$t('general.show_hide_columns')" />

                <PlfListItem v-for="col in hideableColumns"
                             :key="`hideable-column-${col.name}`"
                             :value="col.name"
                             :title="col.label"
                             min-height="35px"
                             class="py-2">
                  <template #prepend="{ active }">
                    <div>
                      <PlfCheckbox square
                                   class="ps-0"
                                   :model-value="active" />
                    </div>
                  </template>
                </PlfListItem>
              </PlfList>
            </template>
          </PlfDropdown>

          <PlfButton icon="mdi.IconFilterRemoveOutline"
                     @click="clearFilters"
                     class="btn-action" />
        </div>
      </template>
      <template #bottom-left>
        <p class="m-0 text-muted"
           v-html="$t('views.table.pagination', pagination)"></p>
      </template>
    </PlfTable>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, useSlots, watch } from 'vue';
import PlfButton from './shared/button/PlfButton.vue';
import PlfTable from './shared/table/PlfTable.vue';
import PlfInput from './shared/input/PlfInput.vue';
import PlfIcon from './shared/icon/PlfIcon.vue';
import PlfDropdown from './shared/dropdown/PlfDropdown.vue';
import PlfList from './shared/list/PlfList.vue';
import PlfListItem from './shared/list/PlfListItem.vue';
import PlfCheckbox from './shared/checkbox/PlfCheckbox.vue';
import DeleteModal from './DeleteModal.vue';
import filterFields from './filterFields.js';
import indexFields from './indexFields.js';
import { useRoute, useRouter } from 'vue-router';
import { QueryBuilder } from '../composables/network/resources/QueryBuilder';
import PlfDivider from './shared/divider/PlfDivider.vue';
import { useApiDestroy } from '../composables/network/resources/useApiDestroy';
import { useApiFetch } from '../composables/network/resources/useApiFetch';
import { useApiStore } from '../composables/network/resources/useApiStore';
import { watchPausable } from '@vueuse/core';
import ResourceActions from './ResourceActions.vue';
import PlfListSubheader from './shared/list/PlfListSubheader.vue';
import { useToast } from './shared/toast/useToast';
import ExportModal from './ExportModal.vue';

const emit = defineEmits(['update:selected']);

const props = defineProps({
  url: {
    type: String,
    required: true
  },

  module: {
    type: String,
    required: true
  },

  model: {
    type: String,
    required: true
  },

  columns: {
    type: Array,
    required: true
  },

  title: {
    type: String,
    required: true
  },

  subtitle: {
    type: String,
    required: false
  },

  selected: {
    type: Array,
    required: false,
    default: () => []
  },

  deletable: {
    type: Boolean,
    required: false,
    default: true
  },

  editable: {
    type: Boolean,
    required: false,
    default: true
  },

  exportable: {
    type: Boolean,
    default: true,
  },

  editLink: {
    type: Function,
    required: false,
    default: () => { },
  }
});

const router = useRouter();
const route = useRoute();

const { resume, pause, isActive } = watchPausable(() => route.query, (newVal) => {
  buildFromUrl(props.url + '?' + decodeURIComponent(Object.entries(newVal).map(([key, val]) => key + '=' + val).join("&")));

  fetch();
}, { deep: true });

const {
  data: userDefinedFilters,
  filters: userDefinedFiltersFilters,
  fetch: fetchUserDefinedFilters,
} = useApiFetch('user-defined-filters');

const {
  store: storeUserDefinedFilter,
  storing: storingUserDefinedFilter
} = useApiStore('user-defined-filters');

const {
  destroy: destroyFilter,
  destroying: destroyingFilter
} = useApiDestroy('user-defined-filters');

const {
  builder,
  data,
  filters,
  loading,
  pagination,
  search,
  selected: selectedRows,
  sort,

  fetch
} = useApiFetch(props.url);

const {
  destroy,
  error,
  destroying
} = useApiDestroy(props.url);

const toast = useToast();

const confirmDelete = ref(false);

const confirmDeleteMultiple = ref(false);

const itemToDelete = ref(null);

const filterToDelete = ref(null);

const confirmDeleteFilter = ref(false);

const showExportModal = ref(false);

const handleDelete = (row) => {
  itemToDelete.value = row;
  confirmDelete.value = true;
};

const handleConfirmDelete = () => {
  destroy(itemToDelete.value.id, {
    onError: () => {
      confirmDelete.value = false;
      itemToDelete.value = null;

      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error.value ?? 'An error occurred while deleting the record.',
        position: 'bottom-right'
      });
    },

    onSuccess: async (data) => {
      confirmDelete.value = false;
      itemToDelete.value = null;

      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: data.message ?? 'Record deleted successfully.',
        position: 'bottom-right'
      });

      // Remove the deleted row from the selected rows
      selectedRows.value = selectedRows.value.filter(r => r.id !== data.id);

      pause();

      // Reset pagination to page 1
      pagination.value.page = 1;

      await fetch();

      await router.push({
        query: builder.build(false)
      });

      resume();
    }
  })
};

const buildFromUrl = (url) => {
  const b = QueryBuilder.fromString(url);

  filters.value = b._filters;
  search.value = b._params.search || '';
  pagination.value.rowsPerPage = (+b._limit) || 10;
  pagination.value.page = (+b._page) || 1;
  sort.value = b._sorts[0];

  if (sort.value) {
    pagination.value.sort = {
      field: sort.value.replace('-', ''),
      direction: sort.value.startsWith('-') ? 'desc' : 'asc'
    }
  }
}

onMounted(async () => {
  pause();

  const query = Object.entries(route.query).map(([key, val]) => key + '=' + val).join("&");

  buildFromUrl(props.url + '?' + decodeURIComponent(query));

  userDefinedFiltersFilters.value = {
    model: `${props.module}.${props.model}`
  };

  fetchUserDefinedFilters();

  await fetch();

  resume();
});

const hideableColumns = computed(() => {
  return props.columns.filter(c => {
    return c.required !== true;
  });
});

const exportableColumns = computed(() => {
  return props.columns.filter(c => {
    return c.exportable === true;
  });
});

const visibleColumns = ref([]);

watch(() => props.columns, () => {
  visibleColumns.value = props.columns
      .filter(c => {
        if (c.required === true) return true;

        if (c.hidden === true) return false;

        return c.hidden !== false || c.hidden !== undefined;
      })
      .map(c => c.name);
}, { immediate: true, deep: true });

const slots = useSlots();

const tableSlots = computed(() => {
  return Object.fromEntries(Object.entries(slots)
    .filter(([key]) => {
      return key.startsWith('body-cell-') ||
        key.startsWith('body-') ||
        key.startsWith('body-selection');
    }));
});

const handleRequest = async ({ pagination: newPagination, sort: newSort }) => {
  if (!isActive.value) return;

  if (newSort?.field && newSort?.direction) {
    pagination.value.sort = newSort;

    sort.value = newSort.direction === 'asc' ? newSort.field : '-' + newSort.field;
  } else {
    sort.value = null;
  }

  if (newPagination) {
    pagination.value.page = +newPagination.page;
    pagination.value.rowsPerPage = +newPagination.rowsPerPage;
  }

  pause();

  await fetch();

  await router.push({
    query: builder.build(false)
  });

  resume();
}

const updateFilter = (col, value) => {
  if (
    value === null ||
    value === undefined ||
    value === '' ||
    (Array.isArray(value) && value.length === 0)
  ) {
    delete filters.value[col];
  } else {
    filters.value[col] = value;
  }

  handleRequest({ pagination: { ...pagination.value, page: 1 }, sort: sort.value });
};

const handleFilterClick = async (filter) => {
  const queryString = Object.entries(filter.filters).map(([key, val]) => {
    return `${key}=${decodeURIComponent(val)}`;
  }).join('&');

  buildFromUrl(props.url + '?' + queryString);

  pause();

  await fetch();

  await router.push({
    query: builder.build(false)
  });

  resume();
}

const handleDeleteFilter = async (filter) => {
  filterToDelete.value = filter;
  confirmDeleteFilter.value = true;
}

const handleConfirmDeleteFilter = async () => {
  await destroyFilter(filterToDelete.value.id);

  confirmDeleteFilter.value = false;
  filterToDelete.value = null;

  await fetchUserDefinedFilters();
}

const newFilterName = ref('');

const handleNewFilterClick = async () => {
  const query = Object.entries(route.query).map(([key, val]) => key + '=' + val).join("&");

  const builder = QueryBuilder.fromString(props.url + '?' + decodeURIComponent(query));

  const params = builder.build();

  const newFilter = {
    name: newFilterName.value,
    model: `${props.module}.${props.model}`,
    filters: params,
    is_default: false,
    is_enabled: true,
  };

  storeUserDefinedFilter(newFilter, {
    onSuccess: () => {
      newFilterName.value = '';

      fetchUserDefinedFilters();
    }
  });
}

const clearFilters = () => {
  filters.value = {};
  sort.value = null;
  search.value = '';

  handleRequest({ pagination: { ...pagination.value, page: 1 }, sort: sort.value });
}

watch(selectedRows, (newVal) => {
  emit('update:selected', newVal);
}, { deep: true });

watch(props.selected, (newVal) => {
  selectedRows.value = newVal;
}, { deep: true });
</script>

<style>
.plf-expand-transition {
  transition: height var(--plf-auto-duration) cubic-bezier(0.33, 1, 0.68, 1);
}
</style>