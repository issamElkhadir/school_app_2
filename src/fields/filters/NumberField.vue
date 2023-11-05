<template>
  <div style="min-width: 5em;">
    <PlfInput size="sm"
            type="number"
            v-model.lazy.number="value" />
  </div>
</template>

<script setup>
import { useModel } from 'vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';

const props = defineProps({
  modelValue: {
    type: [String, Number, Boolean],
    default: null
  },
});

const value = useModel(props, 'modelValue');
</script>