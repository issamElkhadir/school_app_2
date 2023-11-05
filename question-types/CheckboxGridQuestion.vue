<template>
  <BaseGridQuestion>
    <template #column-icon>
      <PlfIcon class="text-muted"
               name="mdi.IconCheckboxBlankOutline" />
    </template>
  </BaseGridQuestion>
</template>

<script setup>
import PlfIcon from '../../shared/icon/PlfIcon.vue';
import BaseGridQuestion from './BaseGridQuestion.vue';

</script>