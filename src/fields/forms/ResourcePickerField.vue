<template>
  <PlfSelect searchable
             :options="data"
             v-model="selected"
             :filter-fn="onFilterFn"
             @load="handleLoad"
             @filter="handleLoad"
             @scroll="handleScroll"
             :debounce="500"
             :multiselect="multiple"
             :option-value="props.optionValue"
             :option-label="props.optionLabel"
             :loading="loading"
             hide-arrow>
    <template #after-last>
      <div v-if="loadingMore" class="w-100 text-center my-2">
        <span class="spinner spinner-border spinner-border-sm"></span>
      </div>
    </template>
  </PlfSelect>
</template>

<script setup>
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useApiFetch } from '@/composables/network/resources/useApiFetch';
import { computed, ref } from 'vue';

const props = defineProps({
  resource: {
    type: String,
    required: true
  },

  optionLabel: {
    type: String,
    default: 'name'
  },

  optionValue: {
    type: String,
    default: 'id'
  },

  multiple: {
    type: Boolean,
    default: false
  },
});

const endpoint = computed(() => {
  const [module, resource] = props.resource.split('/');

  if (!resource) {
    return module.split('-').join('_')
  }

  return resource.split('-').join('_');
});

const data = ref(null);

const loadingMore = ref(false);

const {
  data: fetchedData,
  loading,
  search,
  selected,
  pagination,
  fetch
} = useApiFetch(props.resource, {
  data: null,
  fields: {
    [endpoint.value]: [
      props.optionValue,
      props.optionLabel,
    ]
  }
});

const refetch = async () => {
  await fetch();

  data.value = (data.value ?? []).concat(fetchedData.value);
}

const onFilterFn = async (s) => {
  if (s === '') s = null;

  search.value = s;

  // Reset pagination
  pagination.value.page = 1;

  data.value = [];

  await refetch();
}

const handleLoad = () => {
  refetch();
}

const handleScroll = async (evt) => {
  if (pagination.value.to >= pagination.value.rowsNumber) {
    return;
  }

  if (!loadingMore.value && evt.target.scrollTop + evt.target.clientHeight >= evt.target.scrollHeight) {

    pagination.value.page += 1;

    loadingMore.value = true;

    refetch().finally(() => {
      loadingMore.value = false;
    });
  }
}
</script>