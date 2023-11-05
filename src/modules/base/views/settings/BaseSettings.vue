<template>
  <h2 class="mb-0">General</h2>
  <p class="text-muted">Manage your general settings.</p>

  <PlfDivider class="my-3" />

  <div class="row">
    <div class="col-md-4">
      <h4 class="mb-0 text-muted">
        Global Settings
      </h4>
      <p class="text-muted">
        Manage your global settings.
      </p>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6 mb-3">
          <PlfInput v-model.number="baseSettings['records_per_page']"
                    :invalid="'base/general.records_per_page' in validation"
                    :errors="validation['base/general.records_per_page']"
                    label="Records Per Page" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfSelect v-model="baseSettings['timezone']"
                     :invalid="'base/general.timezone' in validation"
                     :errors="validation['base/general.timezone']"
                     :options="timezones"
                     emit-value
                     searchable
                     label="Timezone" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="baseSettings['date_format']"
                    :invalid="'base/general.date_format' in validation"
                    :errors="validation['base/general.date_format']"
                    label="Date Format" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="baseSettings['is_24_hours']"
                    :invalid="'base/general.is_24_hours' in validation"
                    :errors="validation['base/general.is_24_hours']"
                    label="Is 24 hours" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="baseSettings['notification']"
                    :invalid="'base/general.notification' in validation"
                    :errors="validation['base/general.notification']"
                    label="Notifications" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="baseSettings['academic_year.id']"
                    :invalid="'base/general.academic_year.id' in validation"
                    :errors="validation['base/general.academic_year.id']"
                    label="Active Academic Year" />
        </div>
      </div>
    </div>
  </div>

  <PlfDivider class="my-3" />

  <div class="row">
    <div class="col-md-4">
      <h4 class="mb-0 text-muted">Import Export</h4>
      <p class="text-muted">
        Manage your import export settings.
      </p>
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6 mb-3">
          <PlfInput v-model.number="ioSettings['separator']"
                    :invalid="'base/import_export.separator' in validation"
                    :errors="validation['base/import_export.separator']"
                    label="Records Per Page" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="ioSettings['enclosure']"
                    :invalid="'base/import_export.enclosure' in validation"
                    :errors="validation['base/import_export.enclosure']"
                    label="Enclosure" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="ioSettings['escape']"
                    :invalid="'base/import_export.escape' in validation"
                    :errors="validation['base/import_export.escape']"
                    label="Escape" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfInput v-model="ioSettings['eol']"
                    :invalid="'base/import_export.eol' in validation"
                    :errors="validation['base/import_export.eol']"
                    label="End of Line" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { computed, useModel } from 'vue';

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },

  validation: {
    type: Object,
    required: true
  }
});

const value = useModel(props, 'modelValue', { local: true });

const baseSettings = computed(() => {
  return value.value['base/general'] || {};
});

const ioSettings = computed(() => {
  return value.value['base/import_export'] || {};
});

const timezones = Intl.supportedValuesOf('timeZone').map((tz) => {
  return { label: tz, value: tz };
});
</script>