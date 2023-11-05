<template>
    <ResourceTable :title="t('medical-forms.title')"
                   :columns="columns"
                   module="education"
                   model="medical_form"
                   url="/education/medical-forms"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('medical-forms.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'name', field: 'name', label: t('medical-forms.fields.name'), filterable: true, sortable: true },
    { name: 'rtl_name', field: 'rtl_name', label: t('medical-forms.fields.rtl_name'), filterable: true, sortable: true },
    { name: 'short_name', field: 'short_name', label: t('medical-forms.fields.short_name'), filterable: true, sortable: true },
    { name: 'status', field: 'status', label: t('medical-forms.fields.status'), filterable: true, sortable: true },
    { name: 'school', field: 'school', label: t('medical-forms.fields.school'), filterable: true, sortable: true  , dataType: 'belongs-to', resource: 'schools',},

    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.medical-forms.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>