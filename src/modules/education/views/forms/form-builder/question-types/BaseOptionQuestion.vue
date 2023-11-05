<template>
  <div>
    <label class="form-label"
           :class="{ required: question.is_required }">
      {{ question.title }}
    </label>

    <div class="d-flex mt-3 flex-column gap-3">
      <template v-for="option in props.question.options"
                :key="`option-${option.value}`">
        <slot name="option"
              :option="option"
              :value="value"
              :onInput="val => value = val"></slot>
      </template>
    </div>
  </div>
</template>

<script setup>
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
});

const value = useVModel(props, 'modelValue', emit);
</script>