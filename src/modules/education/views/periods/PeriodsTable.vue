<template>
  <ResourceTable :title="t('periods.title')"
                 :columns="columns"
                 module="education"
                 model="period"
                 url="/education/periods" 
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('periods.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('periods.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('periods.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('periods.fields.status'), filterable: true, sortable: true },
  { name: 'start_date', field: 'start_date', label: t('periods.fields.start_date'), filterable: true, sortable: true },
  { name: 'end_date', field: 'end_date', label: t('periods.fields.end_date'), filterable: true, sortable: true },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.periods.update', params: { id: row.id } };
}
</script>

<style scoped></style>