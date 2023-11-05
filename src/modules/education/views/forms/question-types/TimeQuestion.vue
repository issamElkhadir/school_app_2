<template>
  <div class="text-dark opacity-50 border-bottom d-flex align-items-center my-1 gap-3 w-33 p-1">
    <span class="flex-fill">{{ $t('Time') }}</span>
    <PlfIcon name="mdi.IconClockTimeFourOutline" />
  </div>
</template>

<script setup>
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';

</script>