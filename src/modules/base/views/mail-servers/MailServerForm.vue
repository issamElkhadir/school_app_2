<template>
  <div class="row row-cards">
    <div class="col-md-6">
      <TextField :label="$t('mail-servers.fields.name')"
                 v-model="internalRecord.name"
                 :invalid="'name' in validation"
                 :errors="validation.name"
                 :disabled="disabled"
                 required />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('mail-servers.fields.priority')"
                   v-model="internalRecord.priority"
                   :invalid="'priority' in validation"
                   :errors="validation.priority"
                   :disabled="disabled"
                   required />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('mail-servers.fields.smtp_host')"
                 v-model="internalRecord.smtp_host"
                 :invalid="'smtp_host' in validation"
                 :errors="validation.smtp_host"
                 :disabled="disabled"
                 required />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('mail-servers.fields.smtp_port')"
                   v-model="internalRecord.smtp_port"
                   :invalid="'smtp_port' in validation"
                   :errors="validation.smtp_port"
                   :disabled="disabled"
                   required />
    </div>

    <div class="col-md-6">
      <SelectField :label="$t('mail-servers.fields.smtp_encryption')"
                   v-model="internalRecord.smtp_encryption"
                   :invalid="'smtp_encryption' in validation"
                   :errors="validation.smtp_encryption"
                   :disabled="disabled"
                   :options="encryptions"
                   emit-value />
    </div>

    <div class="col-md-6">
      <BooleanField :label="$t('mail-servers.fields.active')"
                    v-model="internalRecord.active"
                    :invalid="'active' in validation"
                    :errors="validation.active"
                    :disabled="disabled"
                    :true-label="$t('mail-servers.statuses.active')"
                    :false-label="$t('mail-servers.statuses.inactive')"
                    required />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('mail-servers.fields.username')"
                 v-model="internalRecord.username"
                 :invalid="'username' in validation"
                 :errors="validation.username"
                 :disabled="disabled"
                 required />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('mail-servers.fields.password')"
                 v-model="internalRecord.password"
                 :invalid="'password' in validation"
                 :errors="validation.password"
                 type="password"
                 :disabled="disabled"
                 required />
    </div>
  </div>
</template>

<script setup>
import BooleanField from '@/fields/forms/BooleanField.vue';
import NumberField from '@/fields/forms/NumberField.vue';
import SelectField from '@/fields/forms/SelectField.vue';
import TextField from '@/fields/forms/TextField.vue';
import { useVModel } from '@vueuse/core';
import { useI18n } from 'vue-i18n';

const emit = defineEmits(['update:record']);

const props = defineProps({
  record: {
    type: Object,
    required: true,
  },

  validation: {
    type: Object,
    required: true,
  },

  disabled: {
    type: Boolean,
    default: false,
  },
});

const internalRecord = useVModel(props, 'record', emit);

const { t } = useI18n({ useScope: 'global' });

const encryptions = [
  { label: t('mail-servers.encryptions.none'), value: null },
  { label: t('mail-servers.encryptions.ssl'), value: 'ssl' },
  { label: t('mail-servers.encryptions.tls'), value: 'tls' },
];
</script>