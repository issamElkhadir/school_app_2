<template>
  <PlfSelect :options="question.options"
             :label="question.title"
             emit-value
             :required="question.is_required"
             :input-debounce="0"
             clearable
             close-on-select
             :errors="validation"
             v-model="value" 
             :value="answerValue"
             />
</template>

<script setup>
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  question: {
    type: Object,
    required: true
  },

  modelValue: {
    type: String,
  },

  validation: {
    type: Array,
  } ,
  answerValue : {
    type : String
  }
});

const value = useVModel(props, 'modelValue', emit);
</script>