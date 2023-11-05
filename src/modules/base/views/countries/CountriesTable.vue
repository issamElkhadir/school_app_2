<template>
  <ResourceTable :title="t('countries.title')"
                 :columns="columns"
                 module="base"
                 model="country"
                 url="/countries"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('countries.fields.id'), filterable: true, sortable: true, exportable: true, required: true },
  { name: 'name', field: 'name', label: t('countries.fields.name'), filterable: true, exportable: true, sortable: true },
  { name: 'native', field: 'native', label: t('countries.fields.native'), filterable: true, exportable: true, sortable: true },
  { name: 'phone_code', field: 'phone_code', label: t('countries.fields.phone_code'), filterable: true, exportable: true, sortable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.countries.update', params: { id: row.id } };
}

</script>

<style scoped></style>