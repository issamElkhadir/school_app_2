<template>
  <AdminLayout>
    <RouterView />

    <template #sidebar>
      <EducationMenu />
    </template>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/layouts/admin/AdminLayout.vue';
import EducationMenu from './EducationMenu.vue';

</script>