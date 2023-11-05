<template>
  <tr>
    <slot name="default"></slot>
  </tr>
</template>

<script setup>
defineProps({
  columns: {
    type: [Array, Object],
    default: () => [],
    required: true,
  },

  row: {
    type: Object,
    required: true,
    rowIndex: Number
  }
});
</script>

<style scoped>

</style>