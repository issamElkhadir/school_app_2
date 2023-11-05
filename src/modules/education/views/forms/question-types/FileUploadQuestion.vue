<template>
  <div class="d-flex flex-column w-50">
    <div class="d-flex mb-2 justify-content-between">
      {{ $t('Allow only specific file types') }}

      <!-- <PlfSwitch v-model="value.allowSpecificFileTypes" /> -->
    </div>

    <div v-if="value.allowSpecificFileTypes"
         class="row mb-3">
      <div class="col">
        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="document"
                     :disabled="disabled"
                     :label="$t('Document')" />

        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="spreadsheet"
                     :disabled="disabled"
                     :label="$t('Spreadsheet')" />

        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="pdf"
                     :disabled="disabled"
                     :label="$t('PDF')" />

        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="video"
                     :disabled="disabled"
                     :label="$t('Video')" />
      </div>

      <div class="col">
        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="presentation"
                     :disabled="disabled"
                     :label="$t('Presentation')" />

        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="drawing"
                     :disabled="disabled"
                     :label="$t('Drawing')" />

        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="image"
                     :disabled="disabled"
                     :label="$t('Image')" />

        <PlfCheckbox class="ps-0 mb-1"
                     v-model="value.allowedFileTypes"
                     value="audio"
                     :disabled="disabled"
                     :label="$t('Audio')" />
      </div>
    </div>

    <div class="mb-3">
      <PlfInput :label="$t('Max Number of files')"
                :placeholder="$t('Enter a number')"
                type="number"
                min="1"
                max="10"
                :disabled="disabled"
                v-model.number="value.maxNumberOfFiles" />
    </div>

    <div class="mb-3">
      <PlfInput :label="$t('Max file size (MB)')"
                :placeholder="$t('Enter a number')"
                :disabled="disabled"
                type="number"
                max="100"
                min="1"
                v-model.number="value.maxFileSize" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
// import PlfSwitch from '../../shared/forms/PlfSwitch.vue';

const emit = defineEmits(['update:modelValue']);
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';

const props = defineProps({
  modelValue: {
    type: Object
  },

  options: {
    type: Object
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const value = ref({
  allowSpecificFileTypes: false,
  allowedFileTypes: [],
  maxNumberOfFiles: 1,
  maxFileSize: 1
});

watch(value, (val) => {
  emit('update:modelValue', {
    ...props.modelValue,

    options: val
  });
}, { deep: true });

watch(() => props.modelValue, (val) => {
  if (val?.options && typeof val.options === 'object') {
    value.value = val.options;

    if (!Array.isArray(value.value.allowedFileTypes)) {
      value.value.allowedFileTypes = [];
    }
  }
}, { immediate: true });
</script>