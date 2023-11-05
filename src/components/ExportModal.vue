<template>
  <PlfDialog :model-value="visible"
             persistent
             seamless
             :width="550"
             @update:model-value="handleClose">
    <div class="modal-header h-6 py-0 px-3">
      <div class="d-flex w-100 justify-content-between align-items-center">
        <h2 class="modal-title m-0">Export Settings</h2>

        <PlfButton icon="mdi.IconClose"
                   @click="handleClose(false)"
                   class="btn-action" />
      </div>

    </div>

    <div class="modal-body d-flex flex-column p-2 px-3">
      <div class="mb-3">
        <PlfSelect label="Export To: "
                   hide-arrow
                   emit-value
                   v-model="settings.format"
                   :options="exportFormats"
                   close-on-select />
      </div>

      <div class="flex-fill d-flex flex-column">
        <div class="cursor-pointer user-select-none mb-2 d-inline-flex"
             @click="handleAdvancedOptions">
          <PlfIcon name="mdi.IconChevronDown"
                   class="me-1"
                   :class="{ 'rotate-180': !showAdvancedOptions }" />
          <span>
            Advanced
          </span>
        </div>

        <PlfDivider v-show="showAdvancedOptions" />

        <PlfExpandTransitionV2 :when="showAdvancedOptions"
                               class="p-2 pe-3 overflow-auto w-100 flex-fill plf-expand-transition">

          <!-- General -->
          <div class="row">
            <div class="col">
              <div class="mb-2">
                <PlfCheckbox class="ps-0"
                             v-model="settings.compatible_import"
                             label="Compatible Import" />
              </div>
            </div>
          </div>

          <!-- CSV Config -->
          <div v-if="settings.format === 'csv'"
               class="row">
            <ExportCSVConfig v-model:settings="settings.csv" />
          </div>

          <!-- Columns to export -->
          <div class="row mb-3">
            <label class="form-label">Columns</label>

            <div class="d-inline-flex gap-2 mb-2">
              <PlfButton class="btn-sm"
                         @click="handleSelectAll"
                         color="primary"
                         label="Select All" />

              <PlfButton class="btn-sm"
                         @click="handleUnselectAll"
                         color="primary"
                         label="Unselect All" />
            </div>

            <div>
              <div v-for="col in columns"
                   :key="`column-${col.name}`"
                   class="mb-1">
                <PlfCheckbox class="ps-0"
                             :label="col.label"
                             v-model="settings.fields"
                             :value="col.field" />
              </div>
            </div>
          </div>
        </PlfExpandTransitionV2>
      </div>
    </div>

    <div class="modal-footer px-0 py-2">
      <div class="row">
        <div class="col">
          <PlfButton label="Close"
                     class="w-100"
                     @click="handleClose(false)" />
        </div>
        <div class="col">
          <PlfButton label="Export"
                     class="w-100"
                     icon="mdi.IconCloudDownloadOutline"
                     color="primary"
                     :loading="exporting"
                     @click="handleExport" />
        </div>
      </div>
    </div>
  </PlfDialog>
</template>

<script setup>
import { computed, ref } from 'vue';
import PlfButton from './shared/button/PlfButton.vue';
import PlfDialog from './shared/dialog/PlfDialog.vue';
import PlfSelect from './shared/select/PlfSelect.vue';
import PlfCheckbox from './shared/checkbox/PlfCheckbox.vue';
import { QueryBuilder } from '@/composables/network/resources/QueryBuilder';
import PlfExpandTransitionV2 from './shared/transition/PlfExpandTransitionV2.vue';
import PlfIcon from './shared/icon/PlfIcon.vue';
import PlfDivider from './shared/divider/PlfDivider.vue';
import ExportCSVConfig from './ExportCSVConfig.vue';
import { api } from '@/boot/axios';
import { useToast } from './shared/toast/useToast';

const emit = defineEmits(['update:visible']);

const props = defineProps({
  visible: {
    type: Boolean,
    default: false
  },

  columns: {
    type: Array,
    required: true
  },

  resource: {
    type: String,
    required: true,
  },

  search: {
    type: String,
  },

  filters: {
    type: Object,
  },

  sort: {
    type: String,
  }
});

const builder = new QueryBuilder(`${props.resource}/export`);

const showAdvancedOptions = ref(false);

const resourceName = computed(() => {
  if (!props.resource) return null;

  const path = props.resource.split('/');

  return path[path.length - 1].replace(/-/g, '_');
});

const exportFormats = [
  { value: 'xlsx', label: 'Excel' },
  { value: 'csv', label: 'CSV' }
];

const settings = ref({
  format: 'csv',
  compatible_import: true,
  sort: null,
  fields: [],

  // CSV Config
  csv: {
    separator: ',',
    enclosure: '"',
    line_separator: '\n',
    encoding: 'UTF-8',
  },
});

const handleClose = (close = false) => {
  emit('update:visible', close);
}

const url = ref(null);

const exporting = ref(false);

const toast = useToast();

const runExport = () => {
  exporting.value = true;

  api.get(url.value)
    .then((response) => {

      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: response.data.message,
        position: 'bottom-right',
      });

      handleClose(false);
    }).catch(({ response }) => {
      console.log(response);
    }).finally(() => {
      exporting.value = false;
    });
}

const handleExport = () => {
  builder.reset();

  if (settings.value.format === 'csv') {
    for (const key in settings.value.csv) {
      builder.param(`csv[${key}]`, settings.value.csv[key]);
    }
  }

  if (props.search) {
    builder.param('search', props.search);
  }

  if (props.filters) {
    builder.filter(props.filters);
  }

  if (props.sort) {
    builder.sort(props.sort);
  }

  builder.param('format', settings.value.format);
  builder.param('importable', settings.value.compatible_import);

  if (resourceName.value) {
    const fields = [];

    for (const field of settings.value.fields) {
      const col = props.columns.find(col => col.field === field);

      if (col.dataType === 'belongs-to' || col.dataType === 'morph-to') {
        builder.include(col.field);
      } else {
        fields.push(col.field);
      }
    }

    if (fields.length > 0) {
      builder.fields({
        [resourceName.value]: fields
      });
    }

  }
  
  url.value = builder.toString();

  runExport();
}

const handleSelectAll = () => {
  settings.value.fields = props.columns.map(col => col.field);
}

const handleUnselectAll = () => {
  settings.value.fields = [];
}

const handleAdvancedOptions = () => {
  showAdvancedOptions.value = !showAdvancedOptions.value;
}
</script>