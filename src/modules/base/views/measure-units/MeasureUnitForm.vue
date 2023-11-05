<template>
  <div class="row row-cards">
    <div class="col-md-6">
      <PlfInput :label="$t('measure-units.fields.name')"
                v-model="record.name"
                :invalid="'name' in validation"
                :errors="validation.name"
                :disabled="disabled"
                required />
    </div>

    <div class="col-md-6">
      <PlfInput :label="$t('measure-units.fields.ratio')"
                v-model="record.ratio"
                :invalid="'ratio' in validation"
                :errors="validation.ratio"
                type="number"
                :disabled="disabled"
                required />
    </div>

    <div class="col-md-6">
      <PlfSelect :label="$t('measure-units.fields.type')"
                 v-model="record.type"
                 :options="types"
                 emit-value
                 hide-arrow
                 :invalid="'type' in validation"
                 :errors="validation.type"
                 :disabled="disabled"
                 required />
    </div>

    <div class="col-md-6">
      <PlfSelect label="Active"
                 required
                 v-model="record.active"
                 :options="status"
                 emit-value
                 :disabled="disabled"
                 :errors="validation.active"
                 :invalid="'active' in validation">
        <template #option="{ option, onSelect }">
          <div class="p-2"
               @click="onSelect(option)">
            <span class="badge"
                  :class="option.color"></span>
            {{ option.label }}
          </div>
        </template>

        <template #select-header="{ option }">
          <span v-if="option">
            <span class="me-1 badge"
                  :class="option.color"></span>
            {{ option.label }}
          </span>
        </template>
      </PlfSelect>
    </div>

    <div class="col-md-6">
      <BelongsToField resource="measure-unit-categories"
                      v-model="record.category"
                      :disabled="disabled"
                      :invalid="'category.id' in validation"
                      :errors="validation['category.id']"
                      :label="$t('measure-units.fields.category')" />
    </div>
  </div>
</template>

<script setup>
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import { useI18n } from 'vue-i18n';
import { useModel } from 'vue';

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

const record = useModel(props, 'modelValue');

const { t } = useI18n({ useScope: 'global' });

const types = [
  { label: t('measure-units.types.smaller'), value: 'smaller' },
  { label: t('measure-units.types.reference'), value: 'reference' },
  { label: t('measure-units.types.bigger'), value: 'bigger' },
]

const status = [
  { label: t('measure-units.status.active'), value: true, color: 'bg-success' },
  { label: t('measure-units.status.inactive'), value: false, color: 'bg-secondary' }
]
</script>