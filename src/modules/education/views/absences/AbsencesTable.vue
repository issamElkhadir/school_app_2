<template>
    <ResourceTable :title="t('absences.title')"
                   :columns="columns"
                   module="education"
                   model="absence"
                   url="/education/absences"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('absences.fields.id'), filterable: true, sortable: true, required: true , dataType:"number"},
    { name: 'date', field: 'date', label: t('absences.fields.date'), filterable: true, sortable: true, required: true , dataType:"date"},
    { name: 'absence_type', field: 'absence_type', label: t('absences.fields.absence_type'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/absences-types' },
     { name: 'student', field: 'student', label: t('absences.fields.student'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/students', nameAttribute: 'first_name' },
     { name: 'subscription', field: 'subscription', label: t('absences.fields.subscription'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/subscriptions' ,nameAttribute: 'sequence' },
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.absences.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>