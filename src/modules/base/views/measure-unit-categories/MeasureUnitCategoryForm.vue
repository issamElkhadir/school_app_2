<template>
  <div class="row row-cards">
    <div class="col-md-6">
      <TextField :label="$t('measure-unit-categories.fields.name')"
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.name"
                 :invalid="'name' in validation"
                 :errors="validation.name"
                 required />
    </div>

    <div class="col-12">
      <HasManyField v-model="recordMutation.units"
                    :columns="cols"
                    :label="$t('measure-unit-categories.fields.units')"
                    :disabled="disabled"
                    :validation="validation"
                    attribute="units">
        <template #body-cell-name="{ row, invalid, errors }">
          <TextField v-model="row.name"
                     :disabled="disabled"
                     :invalid="invalid"
                     :errors="errors" />
        </template>

        <template #body-cell-ratio="{ row, invalid, errors }">
          <TextField v-model="row.ratio"
                     :invalid="invalid"
                     :disabled="disabled"
                     :errors="errors" />
        </template>

        <template #body-cell-active="{ row, invalid, errors }">
          <BooleanField v-model="row.active"
                        :invalid="invalid"
                        :disabled="disabled"
                        :true-label="$t('general.status.active')"
                        :false-label="$t('general.status.inactive')"
                        :errors="errors" />
        </template>

        <template #body-cell-type="{ row, invalid, errors }">
          <SelectField v-model="row.type"
                       :options="types"
                       emit-value
                       hide-arrow
                       :invalid="invalid"
                       :errors="errors"
                       :disabled="disabled"
                       required />
        </template>
      </HasManyField>
    </div>
  </div>
</template>

<script setup>
import HasManyField from '@/fields/forms/HasManyField.vue';
import SelectField from '@/fields/forms/SelectField.vue';
import TextField from '@/fields/forms/TextField.vue';
import BooleanField from '@/fields/forms/BooleanField.vue';
import { useVModel } from '@vueuse/core';
import { useI18n } from 'vue-i18n';

const emit = defineEmits(['update:record']);

const props = defineProps({
  record: {
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

const recordMutation = useVModel(props, 'record', emit);

const cols = [
  { name: 'name', field: 'name', label: 'Name' },
  { name: 'ratio', field: 'ratio', label: 'Ratio' },
  { name: 'type', field: 'type', label: 'Type' },
  { name: 'active', field: 'active', label: 'Active' },
];

const { t } = useI18n({ useScope: 'global' });

const types = [
  { label: t('measure-units.types.smaller'), value: 'smaller' },
  { label: t('measure-units.types.reference'), value: 'reference' },
  { label: t('measure-units.types.bigger'), value: 'bigger' },
]
</script>