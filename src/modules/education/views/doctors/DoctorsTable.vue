<template>
    <ResourceTable :title="t('doctors.title')"
                   :columns="columns"
                   module="education"
                   model="doctor"
                   url="/education/doctors"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('doctors.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'name', field: 'name', label: t('doctors.fields.name'), filterable: true, sortable: true },
    { name: 'phone', field: 'phone', label: t('doctors.fields.phone'), filterable: true, sortable: true },
    { name: 'address', field: 'email', label: t('doctors.fields.email'), filterable: true, sortable: true },
    { name: 'address', field: 'address', label: t('doctors.fields.address'), filterable: true, sortable: true },
    { name: 'speciality', field: 'speciality', label: t('doctors.fields.speciality'), filterable: true, sortable: true },
    { name: 'school', field: 'school', label: t('doctors.fields.school'), filterable: true, sortable: true  , dataType: 'belongs-to', resource: 'schools',},

    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.doctors.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>