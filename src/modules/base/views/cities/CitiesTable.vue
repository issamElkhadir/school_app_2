<template>
  <ResourceTable :title="t('cities.title')"
                 :columns="columns"
                 module="base"
                 model="city"
                 url="/cities"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('cities.fields.id'), filterable: true, sortable: true, exportable: true, required: true },
  { name: 'name', field: 'name', label: t('cities.fields.name'), filterable: true, exportable: true, sortable: true },
  { name: 'country', field: 'country', label: t('cities.fields.country'), filterable: true, sortable: true, exportable: true, dataType: 'belongs-to', resource: 'countries' },
  { name: 'state', field: 'state', label: t('cities.fields.state'), filterable: true, sortable: true, dataType: 'belongs-to', exportable: true, resource: 'states' },
  { name: 'country_code', field: 'country_code', label: t('cities.fields.country_code'), filterable: true, exportable: true, sortable: true },
  { name: 'state_code', field: 'state_code', label: t('cities.fields.state_code'), filterable: true, exportable: true, sortable: true },
  { name: 'latitude', field: 'latitude', label: t('cities.fields.latitude'), filterable: true, exportable: true, sortable: true },
  { name: 'longitude', field: 'longitude', label: t('cities.fields.longitude'), filterable: true, exportable: true, sortable: true },
  { name: 'flag', field: 'flag', label: t('cities.fields.flag'), filterable: true, sortable: true, exportable: true, dataType: 'boolean' },
  { name: 'actions', field: 'actions' },
];

const editLink = (row) => {
  return { name: 'admin.cities.update', params: { id: row.id } };
}
</script>

<style scoped></style>