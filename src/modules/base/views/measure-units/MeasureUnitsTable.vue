<template>
  <ResourceTable :title="t('measure-units.title')"
                 :columns="columns"
                 module="base"
                 model="measure-unit"
                 url="/measure-units"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('measure-units.fields.id'), filterable: true, sortable: true, required: true, dataType: 'number', exportable: true },
  { name: 'name', field: 'name', label: t('measure-units.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'active', field: 'active', label: t('measure-units.fields.active'), filterable: true, sortable: true, dataType: 'boolean', exportable: true },
  { name: 'ratio', field: 'ratio', label: t('measure-units.fields.ratio'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'type', field: 'type', format: row => t(`measure-units.types.${row.type}`), label: t('measure-units.fields.type'), filterable: true, sortable: true, exportable: true },
  { name: 'category', field: 'category', label: t('measure-units.fields.category'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'measure-unit-categories', exportable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.measure-units.update', params: { id: row.id } };
}
</script>

<style scoped></style>