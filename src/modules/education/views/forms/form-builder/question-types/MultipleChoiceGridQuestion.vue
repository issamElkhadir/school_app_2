<template>
  <BaseOptionGridQuestion>
    <template #option="{ col, row, onInput, value }">
      <PlfRadio color="teal"
                :model-value="value[`${row.value}`]"
                @update:model-value="onInput"
                :name="`${row.value}-${col.value}`"
                :value="col.value" />
    </template>
  </BaseOptionGridQuestion>
</template>

<script setup>
import PlfRadio from '@/components/shared/radio/PlfRadio.vue';
import BaseOptionGridQuestion from './BaseOptionGridQuestion.vue';
</script>