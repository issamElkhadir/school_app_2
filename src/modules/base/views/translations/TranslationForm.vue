<template>
  <div class="row row-cards">

    <div class="col-md-6">
      <PlfSelect :label="$t('translations.fields.module')"
                v-model="record.module"
                emit-value
                :invalid="'module' in validation"
                :errors="validation.module"
                :disabled="disabled"
                :options="modules" />
    </div>

    <div class="col-md-6">
      <PlfInput :label="$t('translations.fields.model')"
                v-model="record.model"
                :invalid="'model' in validation"
                :errors="validation.model"
                :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <PlfInput :label="$t('translations.fields.key')"
                v-model="record.key"
                :invalid="'key' in validation"
                :errors="validation.key"
                :disabled="disabled"
                required />
    </div>

    <div class="col-md-6">
      <PlfInput :label="$t('translations.fields.value')"
                v-model="record.value"
                :invalid="'value' in validation"
                :errors="validation.value"
                :disabled="disabled"
                required />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('translations.fields.language')"
                      v-model="record.language"
                      resource="languages"
                      :invalid="'language.id' in validation"
                      :errors="validation['language.id']"
                      :disabled="disabled"
                      required />
    </div>

  </div>
</template>

<script setup>
import PlfInput from '@/components/shared/input/PlfInput.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },

  validation: {
    type: Object,
    required: true
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const record = useVModel(props, 'modelValue', emit);

const modules = [
  { value: 'base', label: 'Base' },
  { value: 'education', label: 'Education' },
];
</script>