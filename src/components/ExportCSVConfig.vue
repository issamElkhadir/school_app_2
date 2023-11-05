<template>
  <div class="row">
    <!-- Separator, Enclosure, Line Separator -->
    <div class="col">
      <div class="mb-2">
        <PlfSelect label="Separator: "
                   hide-arrow
                   emit-value
                   v-model="settingsMutation.separator"
                   :options="separators" />
      </div>

      <div class="mb-2">
        <PlfSelect label="Enclosure: "
                   hide-arrow
                   emit-value
                   v-model="settingsMutation.enclosure"
                   :options="enclosures" />
      </div>
    </div>
    <div class="col">
      <div class="mb-2">
        <PlfSelect label="Line Separator: "
                   hide-arrow
                   emit-value
                   v-model="settingsMutation.line_separator"
                   :options="lines" />
      </div>

      <div class="mb-2">
        <PlfSelect label="Encoding: "
                   hide-arrow
                   emit-value
                   v-model="settingsMutation.encoding"
                   :options="encoding" />
      </div>

    </div>
  </div>
</template>

<script setup>
import { useVModel } from '@vueuse/core';
import PlfSelect from './shared/select/PlfSelect.vue';

const emit = defineEmits(['update:settings']);

const props = defineProps({
  settings: {
    type: Object,
    required: true
  }
});

const separators = [
  { value: ',', label: 'Comma (,)' },
  { value: ';', label: 'Semicolon (;)' },
  { value: '|', label: 'Pipe (|)' },
  { value: '\t', label: 'Tab (\\t)' },
];

const enclosures = [
  { value: '"', label: 'Double Quote (")' },
  { value: "'", label: 'Single Quote (\')' },
];

const lines = [
  { value: '\n', label: 'New Line (\\n)' },
  { value: '\r\n', label: 'Carriage Return (\\r\\n)' },
];

const encoding = [
  { value: 'UTF-8', label: 'UTF-8' },
  { value: 'UTF-16', label: 'UTF-16' },
  { value: 'ISO-8859-1', label: 'ISO-8859-1' },
  { value: 'ISO-8859-15', label: 'ISO-8859-15' },
  { value: 'Windows-1252', label: 'Windows-1252' },
];

const settingsMutation = useVModel(props, 'settings', emit);
</script>