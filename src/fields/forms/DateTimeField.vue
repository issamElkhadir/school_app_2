<template>
  <PlfDatePicker v-bind="$attrs"
                 mode="dateTime"
                 :timezone="timezone" />
</template>

<script setup>
import PlfDatePicker from '@/components/shared/date-picker/PlfDatePicker.vue';

import { useSettingsStore } from '@/modules/base/stores/settings';
import { computed } from 'vue';

const settingsStore = useSettingsStore();

const timezone = computed(() => {
  return settingsStore.settings['base/general']?.timezone ?? 'UTC';
});
</script>