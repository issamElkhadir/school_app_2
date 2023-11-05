<template>
  <div class="row row-cards">
    <div class="col-md-6">
      <TextField label="Name"
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.name"
                 :errors="validation.name"
                 :invalid="'name' in validation"
                 required />
    </div>

    <div class="col-md-6">
      <TextField label="Code"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.code"
                 :errors="validation.code"
                 :invalid="'code' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Symbol"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.symbol"
                 :errors="validation.symbol"
                 :invalid="'symbol' in validation" />
    </div>

    <div class="col-md-6">
      <BooleanField label="Is Active"
                    required
                    inline
                    :true-label="$t('general.status.active')"
                    :false-label="$t('general.status.inactive')"
                    v-model="recordMutation.is_active"
                    :errors="validation.is_active"
                    :invalid="'is_active' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Rounding"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.rounding"
                 :errors="validation.rounding"
                 :invalid="'rounding' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Symbol Native"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.symbol_native"
                 :errors="validation.symbol_native"
                 :invalid="'symbol_native' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Decimal Digits"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.decimal_digits"
                 :errors="validation.decimal_digits"
                 :invalid="'decimal_digits' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Name Plural"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.name_plural"
                 :errors="validation.name_plural"
                 :invalid="'name_plural' in validation" />
    </div>
  </div>
</template>

<script setup>
import BooleanField from '@/fields/forms/BooleanField.vue';
import TextField from '@/fields/forms/TextField.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:modelValue']);

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