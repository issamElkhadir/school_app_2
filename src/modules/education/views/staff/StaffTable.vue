<template>
  <ResourceTable :title="t('schools.title')"
                 :columns="columns"
                 module="education"
                 model="staff"
                 url="/education/staff"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('staff.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('staff.fields.name'), filterable: true, sortable: true },
  { name: 'phone', field: 'phone', label: t('staff.fields.phone'), filterable: true, sortable: true },
  { name: 'email', field: 'email', label: t('staff.fields.email'), filterable: true, sortable: true },
  { name: 'address', field: 'address', label: t('staff.fields.address'), filterable: true, sortable: true },
  { name: 'salary', field: 'salary', label: t('staff.fields.salary'), filterable: true, sortable: true },
  { name: 'week_hours', field: 'week_hours', label: t('staff.fields.week_hours'), filterable: true, sortable: true },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.staff.update', params: { id: row.id } };
}
</script>

<style scoped></style>