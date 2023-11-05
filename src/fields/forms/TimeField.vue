<template>
  <PlfDatePicker v-bind="$attrs"
                 mode="time"
                 :timezone="timezone"
                 v-model.string="modelValueMutation"
                 :is24hr="is24hr"
                 hide-time-header
                 :masks="{ modelValue: 'hh:mm' }" />
</template>

<script setup>
import PlfDatePicker from '@/components/shared/date-picker/PlfDatePicker.vue';
import { useSettingsStore } from '@/modules/base/stores/settings';
import { computed } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: String
  }
});

const settingsStore = useSettingsStore();

const timezone = computed(() => {
  return settingsStore.settings['base/general']?.timezone ?? 'UTC';
});

const is24hr = computed(() => {
  return settingsStore.settings['base/general']?.is_24_hours;
});

const modelValueMutation = computed({
  get: () => props.modelValue ?? '00:00',
  set: (v) => emit('update:modelValue', v)
})
</script>