<template>
  <ResourceTable :title="t('measure-unit-categories.title')"
                 :columns="columns"
                 module="base"
                 model="measure-unit-category"
                 url="/measure-unit-categories"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('measure-unit-categories.fields.id'), filterable: true, sortable: true, required: true, dataType: 'number', exportable: true },
  { name: 'name', field: 'name', label: t('measure-unit-categories.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.measure-unit-categories.update', params: { id: row.id } };
}
</script>

<style scoped></style>