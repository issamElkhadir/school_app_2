<template>
  <ResourceTable :title="t('unities.title')"
                 :columns="columns"
                 module="education"
                 model="unity"
                 url="/education/unities"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('unities.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('unities.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('unities.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'short_name', field: 'short_name', label: t('unities.fields.short_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('unities.fields.status'), filterable: true, sortable: true },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.unities.update', params: { id: row.id } };
}
</script>

<style scoped></style>