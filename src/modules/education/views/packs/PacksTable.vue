<template>
  <ResourceTable :title="t('packs.title')"
                 :columns="columns"
                 module="education"
                 model="pack"
                 url="/education/packs"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('packs.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('packs.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('packs.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'short_name', field: 'short_name', label: t('packs.fields.short_name'), filterable: true, sortable: true },
  { name: 'invoicing_policy', field: 'invoicing_policy', label: t('packs.fields.invoicing_policy'), filterable: true, sortable: true },
  { name: 'sale_price', field: 'sale_price', label: t('packs.fields.sale_price'), filterable: true, sortable: true },
  { name: 'vat', field: 'vat', label: t('packs.fields.vat'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('packs.fields.status'), filterable: true, sortable: true },

  { name: 'unit', field: 'unit', label: t('packs.fields.unit'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'measureUnits' },
  { name: 'level', field: 'level', label: t('packs.fields.level'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'levels' },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.packs.update', params: { id: row.id } };
}
</script>

<style scoped></style>