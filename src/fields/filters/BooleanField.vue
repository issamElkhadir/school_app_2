<template>
  <PlfCheckbox v-model.lazy="value"
               :binary="false"
               class="ps-0" />
</template>

<script setup>
import { computed } from 'vue';
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: [String, Number, Boolean],
    default: null
  },
});

const value = computed({
  get: () => {
    if (props.modelValue == "true") {
      return true;
    } else if (props.modelValue == "false") {
      return false;
    } else {
      return props.modelValue;
    }
  },
  set: (val) => emit('update:modelValue', val)
});
</script>