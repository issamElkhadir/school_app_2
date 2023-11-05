<template>
  <div class="mb-4">
    <div class="mb-3">
      <PlfInput v-if="describeable"
                floating
                v-model="description"
                :label="$t('Description')" />
    </div>

    <div class="mt-3 mb-3 w-50">

      <span class="py-1 w-100 d-inline-block text-muted border-dotted-bottom">
        {{ $t('Short Answer Text') }}
      </span>

    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import PlfInput from '../../shared/forms/PlfInput.vue';

const emit = defineEmits(['update:modelValue',]);

const props = defineProps({
  options: {
    type: Array,
  },

  modelValue: {
    type: Object,
  },
});

const describeable = computed(() => {
  return props.options.includes('description');
});

const validatable = computed(() => {
  return props.options.includes('validation');
});

const description = ref('');

const validation = ref({});

watch(() => props.modelValue, (value) => {
  if (value) {
    description.value = value.description;
    validation.value = value.validation;
  }
}, { immediate: true });

watch([description, validation], ([description, validation]) => {
  const newValue = {
    ...props.modelValue,

    description,
    validation,
  };

  if (!describeable.value) {
    delete newValue.description;
  }

  if (!validatable.value) {
    delete newValue.validation;
  }

  emit('update:modelValue', newValue);
}, { deep: true });
</script>