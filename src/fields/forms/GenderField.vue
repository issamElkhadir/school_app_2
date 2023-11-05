<template>
  <PlfSelect :options="options"
             v-bind="$attrs"
             emit-value />
</template>

<script setup>
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const options = [
  { value: 'male', label: t('general.gender.male') },
  { value: 'female', label: t('general.gender.female') }
];
</script>