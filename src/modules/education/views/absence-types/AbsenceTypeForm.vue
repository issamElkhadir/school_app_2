<template>
    <div class="row row-cards">
  
      <div class="col-md-6">
        <TextField :label="$t('absence-types.fields.name')"
                   v-model="record.name"
                   :invalid="'name' in validation"
                   :errors="validation.name"
                   :disabled="disabled"
                   required
        />
      </div>
  
      <div class="col-md-6">
        <TextField :label="$t('absence-types.fields.rtl_name')"
                   v-model="record.rtl_name"
                   :invalid="'rtl_name' in validation"
                   :errors="validation.rtl_name"
                   :disabled="disabled"
        />
      </div>
  
      <div class="col-md-6">
        <BooleanField :label="$t('absence-types.fields.status')"
                      v-model="record.status"
                      :invalid="'status' in validation"
                      :errors="validation.status"
                      :disabled="disabled"
        />
      </div>
  
  
    </div>
  </template>
  
  <script setup>
  import {useVModel} from '@vueuse/core';
  import TextField from "@/fields/forms/TextField.vue";
  import BooleanField from "@/fields/forms/BooleanField.vue";
  
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