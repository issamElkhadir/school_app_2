<template>
  <BaseOptionQuestion v-model="value">
    <template #option="{ onInput, option, value }">
      <PlfCheckbox @update:model-value="onInput"
                   :model-value="value"
                   :value="option.value"
                   :label="option.label"
                   class="ps-0"
                   color="teal" />
    </template>
  </BaseOptionQuestion>
</template>

<script setup>
import BaseOptionQuestion from './BaseOptionQuestion.vue';
import { ref, watch } from 'vue';
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';

const emit = defineEmits([
  'update:modelValue',
]);

const props = defineProps({
  modelValue: {
    type: Array,
    required: true,
  },
});

const value = ref([]);

watch(() => props.modelValue, (newVal) => {
  if (newVal && Array.isArray(newVal)) {
    value.value = newVal;
  } else {
    value.value = [];
  }
}, { immediate: true });

watch(value, (newVal) => {
  emit('update:modelValue', newVal);
}, { immediate: true });
</script>