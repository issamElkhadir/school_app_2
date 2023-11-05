<template>
    <ResourceTable :title="t('absence-types.title')"
                   :columns="columns"
                   module="education"
                   model="absence_types"
                   url="/education/absence-types"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('absence-types.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'name', field: 'name', label: t('absence-types.fields.name'), filterable: true, sortable: true },
    { name: 'rtl_name', field: 'rtl_name', label: t('absence-types.fields.rtl_name'), filterable: true, sortable: true },
    { name: 'status', field: 'status', label: t('absence-types.fields.status'), filterable: true, sortable: true },
  
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.absence-types.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>