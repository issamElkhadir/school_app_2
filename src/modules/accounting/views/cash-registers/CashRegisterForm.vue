<template>
  <div class="row row-cards">
    <div class="col-md-4">
      <TextField label="Name"
                 :disabled="disabled"
                 v-model="recordMutation.name"
                 :errors="validation.name"
                 :invalid="'name' in validation"
                 required />
    </div>

    <div class="col-md-4">
      <TextField label="RTL Name"
                 :disabled="disabled"
                 v-model="recordMutation.rtl_name"
                 :errors="validation.rtl_name"
                 :invalid="'rtl_name' in validation" />
    </div>

    <div class="col-md-4">
      <BooleanField label="Status"
                    required
                    :disabled="disabled"
                    v-model="recordMutation.status"
                    true-label="Active"
                    false-label="Inactive"
                    emit-value
                    close-on-select
                    :errors="validation.status"
                    :invalid="'status' in validation" />
    </div>

    <div class="col-md-4">
      <NumberField label="Initial Balance"
                   required
                   :disabled="disabled"
                   v-model="recordMutation.initial_balance"
                   :options="initial_balance"
                   :errors="validation.initial_balance"
                   :invalid="'initial_balance' in validation" />
    </div>

    <div class="col-md-4">
      <BelongsToField label="School"
                      required
                      resource="schools"
                      :disabled="disabled"
                      v-model="recordMutation.owner"
                      :errors="validation['owner.id']"
                      :invalid="'owner.id' in validation" />
    </div>

  </div>
</template>

<script setup>
import BooleanField from "@/fields/forms/BooleanField.vue";
import TextField from '@/fields/forms/TextField.vue';
import NumberField from '@/fields/forms/NumberField.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';
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
  }
});

const recordMutation = useVModel(props, 'record', emit);
</script>