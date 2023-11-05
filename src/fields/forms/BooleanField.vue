<template>
  <PlfSelect v-bind="$attrs"
             :options="options"
             v-model="value"
             emit-value>
    <template #option="{ option, onSelect }">
      <div class="p-2"
           @click="onSelect(option)">
        <span class="badge"
              :class="option.color"></span>
        {{ option.label }}
      </div>
    </template>

    <template #select-header="{ option }">
      <div v-if="option"
           class="w-100 d-flex align-items-center">
        <span class="me-1 badge"
              :class="option.color"></span>
        {{ option.label }}
      </div>
    </template>
  </PlfSelect>
</template>

<script setup>
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { computed } from 'vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  trueValue: {
    type: Boolean,
    default: true
  },

  falseValue: {
    type: Boolean,
    default: false
  },

  nullValue: {
    type: Boolean,
    default: null
  },

  trueLabel: {
    type: String,
    default: 'Yes'
  },

  falseLabel: {
    type: String,
    default: 'No'
  },

  nullLabel: {
    type: String,
    default: 'None'
  },

  modelValue: {
    type: Boolean,
    default: null
  },
});

const options = computed(() => {
  const options = [];

  if (props.clearable) {
    options.push({
      value: props.nullValue,
      label: props.nullLabel,
      color: 'bg-secondary'
    });
  }

  options.push({
    value: props.trueValue,
    label: props.trueLabel,
    color: 'bg-success'
  });

  options.push({
    value: props.falseValue,
    label: props.falseLabel,
    color: props.clearable ? 'bg-warning': 'bg-secondary'
  });

  return options;
});

const value = useVModel(props, 'modelValue', emit, { passive: true });
</script>