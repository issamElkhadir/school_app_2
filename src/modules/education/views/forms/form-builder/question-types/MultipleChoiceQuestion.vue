<template>
  <BaseOptionQuestion>
    <template #option="{ onInput, option, value }">
      <PlfRadio :model-value="value"
                @update:model-value="onInput"
                :value="option.value"
                :label="option.label"
                color="teal" />
    </template>
  </BaseOptionQuestion>
</template>

<script setup>
import BaseOptionQuestion from './BaseOptionQuestion.vue';
import PlfRadio from '@/components/shared/radio/PlfRadio.vue';

</script>