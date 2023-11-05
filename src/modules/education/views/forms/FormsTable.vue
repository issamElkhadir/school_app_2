<template>
    <ResourceTable :title="t('forms.title')"
                   :columns="columns"
                   module="education"
                   model="form"
                   url="/education/forms"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('forms.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'name', field: 'name', label: t('forms.fields.name'), filterable: true, sortable: true },
    { name: 'slug', field: 'slug', label: t('forms.fields.slug'), filterable: true, sortable: true },
    { name: 'is_active', field: 'is_active', label: t('forms.fields.is_active'), filterable: true, sortable: true},
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.forms.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>