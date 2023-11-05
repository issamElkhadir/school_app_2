<template>
  <ResourceTable :title="t('classrooms.title')"
                 :columns="columns"
                 module="education"
                 model="classroom"
                 url="/education/classrooms" 
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('classrooms.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'first_name', label: t('classrooms.fields.first_name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('classrooms.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'capacity', field: 'capacity', label: t('classrooms.fields.capacity'), filterable: true, sortable: true },
  { name: 'image', field: 'image', label: t('classrooms.fields.image'), filterable: true, sortable: true },
  { name: 'school', field: 'school', label: t('classrooms.fields.school'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'schools' },
  { name: 'classroomType', field: 'classroomType', label: t('classrooms.fields.classroomType'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'classroomTypes' },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.classrooms.update', params: { id: row.id } };
}
</script>

<style scoped></style>