<template>
  <ResourceTable :title="t('currencies.title')"
                 :columns="columns"
                 module="base"
                 model="currency"
                 url="/currencies"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('currencies.fields.id'), filterable: true, sortable: true, required: true, dataType: 'number', exportable: true },
  { name: 'name', field: 'name', label: t('currencies.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'is_active', field: 'is_active', label: t('currencies.fields.status'), filterable: true, sortable: true, dataType: 'boolean', exportable: true },
  { name: 'symbol_native', field: 'symbol_native', label: t('currencies.fields.symbol_native'), filterable: true, sortable: true, exportable: true },
  { name: 'decimal_digits', field: 'decimal_digits', label: t('currencies.fields.decimal_digits'), filterable: true, sortable: true, exportable: true },
  { name: 'rounding', field: 'rounding', label: t('currencies.fields.rounding'), filterable: true, sortable: true, exportable: true },
  { name: 'symbol', field: 'symbol', label: t('currencies.fields.symbol'), filterable: true, sortable: true, exportable: true },
  { name: 'name_plural', field: 'name_plural', label: t('currencies.fields.name_plural'), filterable: true, sortable: true, exportable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.currencies.update', params: { id: row.id } };
}
</script>

<style scoped></style>