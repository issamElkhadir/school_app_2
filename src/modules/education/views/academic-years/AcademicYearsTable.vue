<template>
  <ResourceTable :title="t('academic-years.title')"
                 :columns="columns"
                 module="education"
                 model="academic-year"
                 url="/education/academic-years"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('academic-years.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('academic-years.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('academic-years.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('academic-years.fields.status'), filterable: true, sortable: true },
  { name: 'is_locked', field: 'is_locked', label: t('academic-years.fields.is_locked'), filterable: true, sortable: true },
  { name: 'start_date', field: 'start_date', label: t('academic-years.fields.start_date'), filterable: true, sortable: true },
  { name: 'end_date', field: 'end_date', label: t('academic-years.fields.end_date'), filterable: true, sortable: true },
  { name: 'parent_academic_year_name', field: 'parent_academic_year_name', label: t('academic-years.fields.parent_academic_year_name'), filterable: true, sortable: true },

  { name: 'parentAcademicYear', field: 'parentAcademicYear', label: t('academic-years.fields.parentAcademicYear'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'academicYears' },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.academic-years.update', params: { id: row.id } };
}
</script>

<style scoped></style>