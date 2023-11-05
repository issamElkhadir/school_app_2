<template>
  <ResourceTable :title="t('cash-registers.title')"
                 :columns="columns"
                 module="accounting"
                 model="cash-register"
                 url="/accounting/cash-registers"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('cash-registers.fields.id'), filterable: true, sortable: true, required: true, exportable: true },
  { name: 'name', field: 'name', label: t('cash-registers.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('cash-registers.fields.rtl_name'), filterable: true, sortable: true, exportable: true },
  { name: 'status', field: 'status', label: t('cash-registers.fields.status'), filterable: true, sortable: true, dataType: 'boolean', exportable: true },
  { name: 'initial_balance', field: 'initial_balance', label: t('cash-registers.fields.initial_balance'), filterable: true, sortable: true, exportable: true },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.accounting.cash-registers.update', params: { id: row.id } };
}
</script>

<style scoped></style>