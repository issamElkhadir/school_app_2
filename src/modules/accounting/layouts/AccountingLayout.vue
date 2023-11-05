<template>
  <AdminLayout>
    <RouterView />

    <template #sidebar>
      <AccountingMenu />
    </template>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/layouts/admin/AdminLayout.vue';
import AccountingMenu from './AccountingMenu.vue';

</script>