<template>
  <PlfSelect v-bind="$attrs">
    <template v-for="(slot, key) in $slots"
              #[key]="props"
              :key="`slot-${key}`">
      <slot :name="key"
            v-bind="props" />
    </template>
  </PlfSelect>
</template>

<script setup>
import PlfSelect from '@/components/shared/select/PlfSelect.vue';

</script>