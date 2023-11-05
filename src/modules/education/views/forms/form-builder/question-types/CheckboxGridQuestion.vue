<template>
  <BaseOptionGridQuestion :question="question"
                      v-model="value">
    <template #option="{ col, row }">
      <PlfCheckbox @update:model-value="(...args) => onUpdate(row, col, ...args)"
                   :name="`${row.value}-${col.value}`"
                   :model-value="arrayValue[row.value]"
                   color="teal"
                   :value="col.value" />
    </template>
  </BaseOptionGridQuestion>
</template>

<script setup>
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';
import BaseOptionGridQuestion from './BaseOptionGridQuestion.vue';
import { watch, ref, computed } from 'vue';

const emit = defineEmits([
  'update:modelValue',
]);

const props = defineProps({
  question: {
    type: Object,
    required: true
  },

  modelValue: {
    type: Object
  }
});

const value = ref({});

watch(() => props.modelValue, val => {
  if (val && typeof val === 'object') {
    value.value = Object.keys(val).reduce((acc, row) => {
      if (typeof val[row] !== 'object') {
        acc[row] = {};
      } else {
        acc[row] = val[row];
      }

      return acc;
    }, {})
  } else {
    value.value = props.question.options.rows.reduce((acc, row) => {
      acc[row.value] = props.question.options.cols.reduce((acc, col) => {
        acc[col.value] = false;
        return acc;
      }, {});

      return acc;
    }, {});
  }
}, { immediate: true });

watch(value, val => {
  emit('update:modelValue', val);
}, { deep: true });

const onUpdate = (row, col, val, evt) => {
  if (!value.value[row.value] || typeof value.value[row.value] !== 'object') {
    value.value[row.value] = {};
  }

  value.value[row.value][col.value] = evt.target.checked;
};

const arrayValue = computed(() => {
  return Object.keys(value.value).reduce((acc, row) => {
    acc[row] = Object.keys(value.value[row]).reduce((acc, col) => {
      if (value.value[row][col]) {
        acc.push(col);
      }

      return acc;
    }, []);

    return acc;
  }, {})
});
</script>