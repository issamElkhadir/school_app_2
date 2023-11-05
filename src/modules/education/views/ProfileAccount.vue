<template>
  <div class="row p-3">
    <div class="col-12 col-md-8 mx-auto d-flex flex-column gap-3">

      <PlfInput id="name"
                inline
                square
                :label="$t('Name')"
                :disabled="true"
                :invalid="'name' in validation"
                :errors="validation['user.name']"
                :model-value="user.name" />

      <PlfInput id="email"
                inline
                square
                :label="$t('Email')"
                :disabled="disabled"
                :invalid="'email' in validation"
                :errors="validation['user.email']"
                v-model="user.email" />

      <PlfInput id="password"
                inline
                square
                type="password"
                :label="$t('Password')"
                :disabled="disabled"
                :invalid="'password' in validation"
                :errors="validation['user.password']"
                v-model="user.password" />

      <PlfInput id="password_confirmation"
                inline
                square
                type="password"
                :label="$t('Password Confirmation')"
                :disabled="disabled"
                :invalid="'password_confirmation' in validation"
                :errors="validation['user.password_confirmation']"
                v-model="user.password_confirmation" />

    </div>
  </div>
</template>

<script setup>

import { computed } from 'vue';
import PlfInput from "@/components/shared/input/PlfInput.vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },

  disabled: Boolean,

  validation: {
    type: Object
  }
});

const user = computed({
  get: () => props.modelValue,
  set: (val) => emit('onUpdate:modelValue', val),
});
</script>