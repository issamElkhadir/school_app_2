<template>
    <div class="row row-cards">
  
      <div class="col-md-6">
        <TextField :label="$t('appointment-requests.fields.title')"
                   v-model="record.title"
                   :invalid="'title' in validation"
                   :errors="validation.title"
                   :disabled="disabled"
                   required
        />
      </div>
  
      
        <div class="col-md-6">
            <BooleanField :label="$t('appointment-requests.fields.accepted')"
                        v-model="record.accepted"
                        :states="invoicingPolicies"
                        :invalid="'accepted' in validation"
                        :errors="validation.accepted"
                        :disabled="disabled"
                        required
            />
        </div>
      
      <div class="col-md-6">
        <DateField :label="$t('appointment-requests.fields.appointment_date')"
                   v-model="record.appointment_date"
                   :invalid="'appointment_date' in validation"
                   :errors="validation.appointment_date"
                   :disabled="disabled"
        />
      </div>
  
  
      
  
      <div class="col-md-6">
        <BelongsToField :label="$t('appointment-requests.fields.school')"
                        v-model="record.school"
                        resource="schools"
                        :invalid="'school.id' in validation"
                        :errors="validation['school.id']"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <BelongsToField :label="$t('appointment-requests.fields.staff')"
                        v-model="record.staff"
                        resource="education/staff"
                        :invalid="'staff.id' in validation"
                        :errors="validation['staff.id']"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <BelongsToField :label="$t('appointment-requests.fields.student')"
                        v-model="record.student"
                        resource="education/students"
                        :invalid="'student.id' in validation"
                        :errors="validation['student.id']"
                        option-label="first_name"
                        :disabled="disabled"
                        required
        />
      </div>
      <div class="col-md-6">
        <BelongsToField :label="$t('appointment-requests.fields.guardian')"
                        v-model="record.guardian"
                        resource="education/guardians"
                        :invalid="'guardian.id' in validation"
                        :errors="validation['guardian.id']"
                        option-label="first_name"
                        :disabled="disabled"
                        required
        />
      </div>
  <div class="col-md-6">
        <TextField :label="$t('appointment-requests.fields.response')"
                   v-model="record.response"
                   type="textarea"
                   :invalid="'response' in validation"
                   :errors="validation.response"
                   :disabled="disabled"
        />
      </div>

  <div class="col-md-6">
        <TextField :label="$t('appointment-requests.fields.content')"
                   v-model="record.content"
                   type="textarea"
                   :invalid="'content' in validation"
                   :errors="validation.content"
                   :disabled="disabled"
        />
      </div>
    </div>
  </template>
  
  <script setup>
  import BelongsToField from '@/fields/forms/BelongsToField.vue';
  import {useVModel} from '@vueuse/core';
  import TextField from "@/fields/forms/TextField.vue";
  import BooleanField from "@/fields/forms/BooleanField.vue";
  import DateField from "@/fields/forms/DateField.vue";
  
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