<template>
  <div style="width: 150px;">
    <PlfSelect multiselect
             searchable
             :options="data"
             v-model="selected"
             :filter-fn="onFilterFn"
             @load="handleLoad"
             @filter="handleLoad"
             :option-value="props.field.valueAttribute ?? 'id'"
             :option-label="props.field.labelAttribute ?? 'name'"
             :loading="loading"
             size="sm"
             hide-arrow />
  </div>
</template>

<script setup>
import { computed, useModel, watch } from 'vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useApiFetch } from '@/composables/network/resources/useApiFetch';

const props = defineProps({
  field: {
    type: Object,
    required: true
  },

  modelValue: {
    type: Array,
    default: () => ([])
  }
});

const endpoint = computed(() => {
  const [module, resource] = props.field.resource.split('/');

  if (!resource) {
    return module.split('-').join('_')
  }

  return resource.split('-').join('_');
});

const {
  data,
  loading,
  search,
  selected,
  pagination,
  fetch
} = useApiFetch(props.field.resource, {
  data: null,
  fields: {
    [endpoint.value]: [
      props.field.valueAttribute ?? 'id',
      props.field.labelAttribute ?? 'name'
    ]
  }
});

const value = useModel(props, 'modelValue');

let timeout = null;

const onFilterFn = (s) => {
  clearTimeout(timeout);

  timeout = setTimeout(() => {
    fetch({ filter: s });
  }, 2000);
}

const handleLoad = () => {
  fetch();
}

watch(selected, (newVal) => {
  value.value = newVal.map((v) => v[props.field.valueAttribute ?? 'id']);
}, { deep: true });
</script>