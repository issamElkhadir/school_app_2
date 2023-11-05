<template>
    <ResourceTable :title="t('participators.title')"
                   :columns="columns"
                   module="education"
                   model="participator"
                   url="/education/participators"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('participators.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'email', field: 'email', label: t('participators.fields.email'), filterable: true, sortable: true },
    { name: 'first_name', field: 'first_name', label: t('participators.fields.first_name'), filterable: true, sortable: true },
    { name: 'last_name', field: 'last_name', label: t('participators.fields.last_name'), filterable: true, sortable: true },
    { name: 'password', field: 'password', label: t('participators.fields.password'), filterable: true, sortable: true },
  
    { name: 'student', field: 'student', label: t('participators.fields.student'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/students' ,nameAttribute:"first_name"},
    { name: 'form', field: 'form', label: t('participators.fields.form'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'forms' },
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.participators.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>