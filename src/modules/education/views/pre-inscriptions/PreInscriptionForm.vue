<template>
    <div class="row row-cards">
  
      <div class="col-md-6">
        <TextField :label="$t('pre-inscriptions.fields.title')"
                   v-model="record.title"
                   :invalid="'title' in validation"
                   :errors="validation.title"
                   :disabled="disabled"
                   required
        />
      </div>  
      <div class="col-md-6">
        <DateTimeField :label="$t('pre-inscriptions.fields.start_date_time')"
                   v-model="record.start_date_time"
                   :invalid="'start_date_time' in validation"
                   :errors="validation.start_date_time"
                   :disabled="disabled"
                   required
        />
      </div>  
      <div class="col-md-6">
        <DateTimeField :label="$t('pre-inscriptions.fields.end_date_time')"
                   v-model="record.end_date_time"
                   :invalid="'end_date_time' in validation"
                   :errors="validation.end_date_time"
                   :disabled="disabled"
                   required
        />
      </div>  
      <div class="col-md-6">
        <BelongsToField :label="$t('pre-inscriptions.fields.level')"
                        v-model="record.level"
                        resource="education/levels"
                        :invalid="'level.id' in validation"
                        :errors="validation['level.id']"
                        :disabled="disabled"
                        required
        />
      </div>
  
      <div class="col-md-6">
        <BelongsToField :label="$t('pre-inscriptions.fields.school')"
                        v-model="record.school"
                        resource="schools"
                        :invalid="'school.id' in validation"
                        :errors="validation['school.id']"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <BelongsToField :label="$t('pre-inscriptions.fields.form')"
                        v-model="record.form"
                        resource="education/forms"
                        :invalid="'form.id' in validation"
                        :errors="validation['form.id']"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <BooleanField :label="$t('pre-inscriptions.fields.status')"
                      v-model="record.status"
                      :invalid="'status' in validation"
                      :errors="validation.status"
                      :disabled="disabled"
        />
      </div>
      <div class="col-md-6">
        <TextField :label="$t('pre-inscriptions.fields.description')"
                   v-model="record.description"
                   :invalid="'description' in validation"
                   :errors="validation.description"
                   :disabled="disabled"
                   type="textarea"
        />
      </div>
    </div>
  </template>
  
  <script setup>
  import BelongsToField from '@/fields/forms/BelongsToField.vue';
  import {useVModel} from '@vueuse/core';
  import TextField from "@/fields/forms/TextField.vue";
  import BooleanField from "@/fields/forms/BooleanField.vue";
  import DateTimeField from "@/fields/forms/DateTimeField.vue";
  
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