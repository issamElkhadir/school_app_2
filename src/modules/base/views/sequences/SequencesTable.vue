<template>
  <ResourceTable :title="t('sequences.title')"
                 :columns="columns"
                 module="base"
                 model="sequence"
                 url="/sequences"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('sequences.fields.id'), filterable: true, sortable: true, required: true, dataType: 'number', exportable: true },
  { name: 'name', field: 'name', label: t('sequences.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'school', field: 'school', label: t('sequences.fields.school'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'schools', exportable: true },
  { name: 'code', field: 'code', label: t('sequences.fields.code'), filterable: true, sortable: true, exportable: true },
  { name: 'start_value', field: 'start_value', label: t('sequences.fields.start_value'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'end_value', field: 'end_value', label: t('sequences.fields.end_value'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'next_value', field: 'next_value', label: t('sequences.fields.next_value'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'prefix', field: 'prefix', label: t('sequences.fields.prefix'), filterable: true, sortable: true, exportable: true },
  { name: 'suffix', field: 'suffix', label: t('sequences.fields.suffix'), filterable: true, sortable: true, exportable: true },
  { name: 'length', field: 'length', label: t('sequences.fields.length'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'step', field: 'step', label: t('sequences.fields.step'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.sequences.update', params: { id: row.id } };
}
</script>

<style scoped></style>