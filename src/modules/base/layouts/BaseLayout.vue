<template>
  <AdminLayout>
    <RouterView />

    <template #sidebar>
      <BaseMenu />
    </template>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/layouts/admin/AdminLayout.vue';
import BaseMenu from './BaseMenu.vue';

</script>