<template>
  <div class="row row-cards">
    <div class="col-md-6">
      <TextField :label="$t('sequences.fields.name')"
                 v-model="recordMutation.name"
                 :invalid="'name' in validation"
                 :errors="validation.name"
                 :disabled="disabled"
                 required />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('sequences.fields.code')"
                 v-model="recordMutation.code"
                 :invalid="'code' in validation"
                 :errors="validation.code"
                 :disabled="disabled"
                 required />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('sequences.fields.school')"
                      v-model="recordMutation.school"
                      resource="schools"
                      :invalid="'school.id' in validation"
                      :errors="validation['school.id']"
                      :disabled="disabled"
                      required />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('sequences.fields.start_value')"
                   v-model="recordMutation.start_value"
                   :invalid="'start_value' in validation"
                   :errors="validation.start_value"
                   :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('sequences.fields.end_value')"
                      v-model="recordMutation.end_value"
                      :invalid="'end_value' in validation"
                      :errors="validation.end_value"
                      :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('sequences.fields.next_value')"
                   v-model="recordMutation.next_value"
                   :invalid="'next_value' in validation"
                   :errors="validation.next_value"
                   :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('sequences.fields.prefix')"
                 v-model="recordMutation.prefix"
                 :invalid="'prefix' in validation"
                 :errors="validation.prefix"
                 :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('sequences.fields.suffix')"
                 v-model="recordMutation.suffix"
                 :invalid="'suffix' in validation"
                 :errors="validation.suffix"
                 :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('sequences.fields.length')"
                   v-model="recordMutation.length"
                   :invalid="'length' in validation"
                   :errors="validation.length"
                   :disabled="disabled" />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('sequences.fields.step')"
                      v-model="recordMutation.step"
                      :invalid="'step' in validation"
                      :errors="validation.step"
                      :disabled="disabled" />
    </div>

    <div class="col-12">
      <h3 class="border-bottom pb-1">Legend (for prefix, suffix)</h3>

      <div class="row text-muted">
        <div class="col-md-4 d-inline-flex flex-column gap-2">
          <span>Current Year with Century: {year}s</span>
          <span>Current Year without Century: {y}s</span>
          <span>Month: {month}s</span>
          <span>Day: {day}s</span>
        </div>
        <div class="col-md-4 d-inline-flex flex-column gap-2">
          <span>Day of the Year: {doy}s</span>
          <span>Week of the Year: {woy}s</span>
          <span>Day of the Week (0:Monday): {weekday}s</span>
        </div>
        <div class="col-md-4 d-inline-flex flex-column gap-2">
          <span>Hour 00&srarr;24: {h24}s</span>
          <span>Hour 00&srarr;12: {h12}s</span>
          <span>Minute: {min}s</span>
          <span>Second: {sec}s</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import NumberField from '@/fields/forms/NumberField.vue';
import TextField from '@/fields/forms/TextField.vue';
import { useVModel } from '@vueuse/core';

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
</script>