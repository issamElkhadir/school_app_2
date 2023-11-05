<template>
  <ResourceTable title="States"
                 module="base"
                 model="state"
                 url="states"
                 :columns="columns"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('states.fields.id'), filterable: true, sortable: true, required: true, exportable: true },
  { name: 'name', field: 'name', label: t('states.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'country', field: 'country', label: t('states.fields.country'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'countries', exportable: true },
  { name: 'country_code', field: 'country_code', label: t('states.fields.country_code'), filterable: true, sortable: true, exportable: true },
  { name: 'fips_code', field: 'fips_code', label: t('states.fields.fips_code'), filterable: true, sortable: true, exportable: true },
  { name: 'iso2', field: 'iso2', label: t('states.fields.iso2'), filterable: true, sortable: true, exportable: true },
  { name: 'type', field: 'type', label: t('states.fields.type'), filterable: true, sortable: true, exportable: true },
  { name: 'latitude', field: 'latitude', label: t('states.fields.latitude'), filterable: true, sortable: true, exportable: true },
  { name: 'longitude', field: 'longitude', label: t('states.fields.longitude'), filterable: true, sortable: true, exportable: true },
  { name: 'flag', field: 'flag', label: t('states.fields.flag'), filterable: true, sortable: true, dataType: 'boolean', exportable: true },
  { name: 'actions', required: true }
];

const editLink = ({ id }) => {
  return { name: 'admin.states.update', params: { id } };
}

</script>

<style scoped></style>