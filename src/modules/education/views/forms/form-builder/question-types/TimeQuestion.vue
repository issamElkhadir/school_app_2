<template>
  <PlfDatePicker :label="question.title"
                 :required="question.is_required"
                 v-model="value"
                 :value="answerValue"
                 mode="time"
                 input-color="teal"
                 color="green" />
</template>

<script setup>
import PlfDatePicker from '@/components/shared/date-picker/PlfDatePicker.vue';
import { ref, watch } from 'vue';

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

const value = ref(new Date());

watch(value, (newValue) => {
  emit('update:modelValue', newValue);
}, { deep: true });

watch(() => props.modelValue, (newValue) => {
  if (!newValue) return;

  value.value = newValue;
}, { immediate: true });
</script>