<template>
  <PlfDatePicker :label="question.title"
                 :required="question.is_required"
                 v-model="value"
                 :value="answerValue"
                 input-color="teal"
                 color="green" />
</template>

<script setup>
import PlfDatePicker from '@/components/shared/date-picker/PlfDatePicker.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits([
  'update:modelValue',
]);

const props = defineProps({
  question: {
    type: Object,
    required: true
  },

  modelValue: {
    type: String
  },
  answerValue : {
    type : String
  }
});

const value = useVModel(props, 'modelValue', emit);
</script>