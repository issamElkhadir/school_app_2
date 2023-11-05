<template>
    <div class="row row-cards">
  
      <div class="col-md-6">
        <TextField :label="$t('doctors.fields.name')"
                   v-model="record.name"
                   :invalid="'name' in validation"
                   :errors="validation.name"
                   :disabled="disabled"
                   required
        />
      </div>
  
      <div class="col-md-6">
        <NumberField :label="$t('doctors.fields.phone')"
                   v-model="record.phone"
                   :invalid="'phone' in validation"
                   :errors="validation.phone"
                   :disabled="disabled"
                   required
        />
      </div>
  
      <div class="col-md-6">
        <TextField :label="$t('doctors.fields.email')"
                   v-model="record.email"
                   :invalid="'email' in validation"
                   :errors="validation.email"
                   :disabled="disabled"
                   required
        />
      </div>
      
      <div class="col-md-6">
        <TextField :label="$t('doctors.fields.speciality')"
                   v-model="record.speciality"
                   :invalid="'short_name' in validation"
                   :errors="validation.speciality"
                   :disabled="disabled"
                   required
        />
      </div>
      <div class="col-md-6">
        <BelongsToField :label="$t('doctors.fields.school')"
                        v-model="record.school"
                        resource="education/levels"
                        :invalid="'school.id' in validation"
                        :errors="validation['school.id']"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <TextField :label="$t('doctors.fields.address')"
                      v-model="record.address"
                      type="textarea"
                      :invalid="'address' in validation"
                      :errors="validation.address"
                      :disabled="disabled"
        />
      </div>
  
  
  
    </div>
  </template>
  
  <script setup>
  import {useVModel} from '@vueuse/core';
  import TextField from "@/fields/forms/TextField.vue";
  import BelongsToField from "@/fields/forms/BelongsToField.vue";
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