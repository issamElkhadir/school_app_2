<template>
    <ResourceTable :title="t('appointment-requests.title')"
                   :columns="columns"
                   module="education"
                   model="appointment_request"
                   url="/education/appointment-requests"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('appointment-requests.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'title', field: 'title', label: t('appointment-requests.fields.title'), filterable: true, sortable: true },
    // { name: 'content', field: 'content', label: t('appointment-requests.fields.content'), filterable: true, sortable: true },
    { name: 'accepted', field: 'accepted', label: t('appointment-requests.fields.accepted'), filterable: true, sortable: true },
    { name: 'response', field: 'response', label: t('appointment-requests.fields.response'), filterable: true, sortable: true },
    { name: 'appointment_date', field: 'appointment_date', label: t('appointment-requests.fields.appointment_date'), filterable: true, sortable: true , dataType:"date" },

  
    { name: 'school', field: 'school', label: t('appointment-requests.fields.school'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'schools' },
    { name: 'staff', field: 'staff', label: t('appointment-requests.fields.staff'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/staff' },
    { name: 'student', field: 'student', label: t('appointment-requests.fields.student'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/students' ,nameAttribute:"first_name"},
    { name: 'guardian', field: 'guardian', label: t('appointment-requests.fields.guardian'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/guardians' ,nameAttribute:"first_name"},
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.appointment-requests.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>