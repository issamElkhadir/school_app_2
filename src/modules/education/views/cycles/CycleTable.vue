<template>
  <ResourceTable :title="t('cycles.title')"
                 :columns="columns"
                 module="education"
                 model="cycle"
                 url="/education/cycles"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('cycles.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('cycles.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('cycles.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'short_name', field: 'short_name', label: t('cycles.fields.short_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('cycles.fields.status'), filterable: true, sortable: true },
  // { name: 'description', field: 'description', label: t('cycles.fields.description'), filterable: true, sortable: true },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.cycles.update', params: { id: row.id } };
}
</script>

<style scoped></style>