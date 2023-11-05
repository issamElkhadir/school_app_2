<template>
    <ResourceTable :title="t('contract-types.title')"
                   :columns="columns"
                   module="education"
                   model="contract_type"
                   url="/education/contract-types"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('contract-types.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'name', field: 'name', label: t('contract-types.fields.name'), filterable: true, sortable: true },
    { name: 'rtl_name', field: 'rtl_name', label: t('contract-types.fields.rtl_name'), filterable: true, sortable: true },
    { name: 'short_name', field: 'short_name', label: t('contract-types.fields.short_name'), filterable: true, sortable: true },
    { name: 'status', field: 'status', label: t('contract-types.fields.status'), filterable: true, sortable: true },
    { name: 'school', field: 'school', label: t('contract-types.fields.school'), filterable: true, sortable: true  , dataType: 'belongs-to', resource: 'schools',},

    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.contract-types.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>