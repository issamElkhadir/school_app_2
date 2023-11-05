<template>
    <div class="row row-cards">
  
      <div class="col-md-6">
        <DateField :label="$t('employment-contracts.fields.contract_start_date')"
                   v-model="record.contract_start_date"
                   :invalid="'contract_start_date' in validation"
                   :errors="validation.contract_start_date"
                   :disabled="disabled"
        />
      </div>
      <div class="col-md-6">
        <DateField :label="$t('employment-contracts.fields.contract_end_date')"
                   v-model="record.contract_end_date"
                   :invalid="'contract_end_date' in validation"
                   :errors="validation.contract_end_date"
                   :disabled="disabled"
        />
      </div>

  
      <div class="col-md-6">
        <BelongsToField :label="$t('employment-contracts.fields.staff')"
                        v-model="record.staff"
                        resource="education/staff"
                        :invalid="'staff.id' in validation"
                        :errors="validation['staff.id']"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <BelongsToField :label="$t('employment-contracts.fields.contract_type')"
                        v-model="record.contract_type"
                        resource="education/contract-types"
                        :invalid="'contract_type.id' in validation"
                        :errors="validation['contract_type.id']"
                        :disabled="disabled"
                        required
        />
      </div>
  
      <div class="col-md-6">
        <NumberField :label="$t('employment-contracts.fields.net_salary')"
                     v-model="record.net_salary"
                     :invalid="'net_salary' in validation"
                     :errors="validation.net_salary"
                     :disabled="disabled"
        />
      </div>
      <div class="col-md-6">
        <NumberField :label="$t('employment-contracts.fields.brut_salary')"
                     v-model="record.brut_salary"
                     :invalid="'brut_salary' in validation"
                     :errors="validation.brut_salary"
                     :disabled="disabled"
        />
      </div>
      <div class="col-md-6">
        <NumberField :label="$t('employment-contracts.fields.nbr_days_off')"
                     v-model="record.nbr_days_off"
                     :invalid="'nbr_days_off' in validation"
                     :errors="validation.nbr_days_off"
                     :disabled="disabled"
        />
      </div>
  
  
    </div>
  </template>
  
  <script setup>
  import BelongsToField from '@/fields/forms/BelongsToField.vue';
  import {useVModel} from '@vueuse/core';
  import DateField from "@/fields/forms/DateField.vue";
  import NumberField from "@/fields/forms/NumberField.vue";
  
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

  
  </script>