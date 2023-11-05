<template>
    <ResourceTable :title="t('pre-inscriptions.title')"
                   :columns="columns"
                   module="education"
                   model="pre_inscription"
                   url="/education/pre-inscriptions"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('pre-inscriptions.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'title', field: 'title', label: t('pre-inscriptions.fields.title'), filterable: true, sortable: true },
    { name: 'slug', field: 'slug', label: t('pre-inscriptions.fields.slug'), filterable: true, sortable: true },
    { name: 'start_date_time', field: 'start_date_time', label: t('pre-inscriptions.fields.start_date_time'), filterable: true, sortable: true , dataType :'date' },
    { name: 'end_date_time', field: 'end_date_time', label: t('pre-inscriptions.fields.end_date_time'), filterable: true, sortable: true , dataType :'date' },
    { name: 'status', field: 'status', label: t('pre-inscriptions.fields.status'), filterable: true, sortable: true },
  
    { name: 'school', field: 'school', label: t('pre-inscriptions.fields.school'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'schools' },
    { name: 'level', field: 'level', label: t('pre-inscriptions.fields.level'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'levels' },
    { name: 'form', field: 'form', label: t('pre-inscriptions.fields.form'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'forms' },
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.pre-inscriptions.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>