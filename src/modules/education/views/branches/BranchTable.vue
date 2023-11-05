<template>
  <ResourceTable :title="t('branches.title')"
                 :columns="columns"
                 module="education"
                 model="branch"
                 url="/education/branches"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('branches.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('branches.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('branches.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'short_name', field: 'short_name', label: t('branches.fields.short_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('branches.fields.status'), filterable: true, sortable: true },
  // { name: 'description', field: 'description', label: t('branches.fields.description'), filterable: true, sortable: true },
  { name: 'cycle', field: 'cycle', label: t('branches.fields.cycle'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'cycles' },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.branches.update', params: { id: row.id } };
}
</script>

<style scoped></style>