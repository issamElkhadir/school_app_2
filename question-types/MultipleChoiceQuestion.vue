<template>
  <BaseOptionQuestion list-class="list-unstyled">
    <template #option-icon>
      <PlfIcon name="mdi.IconRadioButtonUnchecked"
               class="text-muted" />
    </template>
  </BaseOptionQuestion>
</template>

<script setup>
import PlfIcon from '../../shared/icon/PlfIcon.vue';
import BaseOptionQuestion from './BaseOptionQuestion.vue';
</script>