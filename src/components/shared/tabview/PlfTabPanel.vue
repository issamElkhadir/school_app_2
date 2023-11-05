<template>
  <slot></slot>
</template>

<script setup>
defineProps({
  header: null,
  disabled: {
    type: Boolean,
    default: () => false
  }
});
</script>
