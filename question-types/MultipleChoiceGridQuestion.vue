<template>
  <BaseGridQuestion>
    <template #column-icon>
      <PlfIcon class="text-muted"
               name="mdi.IconRadioboxBlank" />
    </template>
  </BaseGridQuestion>
</template>

<script setup>
import BaseGridQuestion from './BaseGridQuestion.vue';
import PlfIcon from '../../shared/icon/PlfIcon.vue';

</script>