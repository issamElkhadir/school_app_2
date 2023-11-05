<template>
  <PlfInput size="sm"
            v-model.lazy="value" />
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