<template>
  <h2 class="mb-0">Education</h2>
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
          <BelongsToField resource="sequences"
                          v-model="educationSettings['subscription_sequence']"
                          :invalid="'education/general.subscription_sequence.id' in validation"
                          :errors="validation['education/general.subscription_sequence.id']"
                          label="Subscription Sequence" />
        </div>

        <div class="col-md-6 mb-3">
          <BelongsToField resource="sequences"
                          v-model="educationSettings['payment_bill_sequence']"
                          :invalid="'education/general.payment_bill_sequence.id' in validation"
                          :errors="validation['education/general.payment_bill_sequence.id']"
                          label="Payment Bill Sequence" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfSelect v-model="educationSettings['start_month']"
                     :options="months"
                     emit-value
                     :invalid="'education/general.start_month' in validation"
                     :errors="validation['education/general.start_month']"
                     label="Start Month" />
        </div>

        <div class="col-md-6 mb-3">
          <PlfSelect v-model="educationSettings['end_month']"
                     :options="months"
                     emit-value
                     :invalid="'education/general.end_month' in validation"
                     :errors="validation['education/general.end_month']"
                     label="End Month" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';
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

const educationSettings = computed(() => {
  return value.value['education/general'] || {};
});

const months = [
  { value: 1, label: 'January' },
  { value: 2, label: 'February' },
  { value: 3, label: 'March' },
  { value: 4, label: 'April' },
  { value: 5, label: 'May' },
  { value: 6, label: 'June' },
  { value: 7, label: 'July' },
  { value: 8, label: 'August' },
  { value: 9, label: 'September' },
  { value: 10, label: 'October' },
  { value: 11, label: 'November' },
  { value: 12, label: 'December' }
];
</script>