<template>
  <PlfKanban :columns="columns"
             :data="items"
             :loadings="loadings"
             :deletable="true"
             :editable="true"
             class="pb-3 flex-fill overflow-hidden"
             :status-column="statusColumn"
             :description-column="descriptionColumn"
             :name-column="nameColumn"
             :load-more="handleLoadMore"
             :title="title"
             draggable>
    <template #item="props">
      <slot name="item"
            v-bind="props"></slot>
    </template>
  </PlfKanban>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import PlfKanban from './shared/kanban/PlfKanban.vue';
import { useApiFetch } from '../composables/network/resources/useApiFetch';
import axios from 'axios';

const props = defineProps({
  columns: {
    type: Array
  },

  url: {
    type: String,
  },

  statusColumn: {
    type: String,
    default: 'status'
  },

  nameColumn: {
    type: String,
    default: 'name',
  },

  descriptionColumn: {
    type: String,
    default: 'description'
  },

  title: {
    type: String,
  }
});

const items = ref({});

const resources = ref({});

const loadings = ref({});

onMounted(() => {
  const requests = props.columns.map(column => {
    const resource = useApiFetch(props.url);

    resource.filters.value = {
      ...resource.filters.value,
      [props.statusColumn]: column.id,
    };

    resources.value[column.id] = resource;

    loadings.value[column.id] = true;

    return resource.fetch();
  });

  axios.all(requests).then(axios.spread((...responses) => {
    responses.forEach((response, index) => {
      items.value[props.columns[index].id] = {
        data: response.data.data,
        pagination: {
          total: response.data.meta.total,
          from: response.data.meta.from,
          to: response.data.meta.to,
        },
      };
    });
  })).finally(() => {
    Object.keys(loadings.value).forEach(key => {
      loadings.value[key] = false;
    });
  });
});

const handleLoadMore = ({ column }) => {
  const resource = resources.value[column];

  resource.pagination.page += 1;

  loadings.value[column] = true;

  resource.fetch().then(response => {
    // Merge data
    items.value[column].data = items.value[column].data.concat(response.data.data);

    items.value[column].pagination = {
      total: response.data.meta.total,
      from: items.value[column].pagination.from,
      to: response.data.meta.to,
    };
  }).finally(() => {
    loadings.value[column] = false;
  });
};
</script>