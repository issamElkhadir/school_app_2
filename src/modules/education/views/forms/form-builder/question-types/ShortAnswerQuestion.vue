<template>
  <PlfInput v-model="answer"
            :label="question.title"
            :hint="question.description"
            :required="question.is_required"
            :errors="validation" 
            :value="answerValue"/>
</template>

<script setup>
import PlfInput from '@/components/shared/input/PlfInput.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits([
  'update:modelValue',
]);

const props = defineProps({
  question: {
    type: Object,
    required: true,
  },

  modelValue: {
    type: String,
  },

  validation: {
    type: Object,
  },
  answerValue : {
    
  }
});

const answer = useVModel(props, 'modelValue', emit);

</script>