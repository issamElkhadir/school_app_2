<template>
  <div style="min-width: 5em;">
    <PlfSelect :options="options"
             :multiselect="true"
             v-model="value"
             transparent
             size="sm"
             emit-value
             :hide-arrow="true" />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: [String, Number, Boolean, Array],
    default: null
  },

  field: {
    type: Object,
    required: true
  }
});

const value = useVModel(props, 'modelValue', emit);

const options = computed(() => {
  const items = props.field.enum ?? {};

  if (typeof items === 'object') {
    return Object.keys(items).map(key => ({ value: key, label: items[key] }));
  } else if (Array.isArray(items)) {
    return items;
  } else {
    return [];
  }
});
</script>