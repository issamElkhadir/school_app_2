<template>
  <RouterView />
</template>

<script setup>
import { useSettingsStore } from '@/modules/base/stores/settings';
import { onMounted } from 'vue';


const { fetch } = useSettingsStore();

onMounted(() => {
  fetch();
});
</script>