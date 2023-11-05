<template>
  <ResourceTable :title="t('articles.title')"
                 :columns="columns"
                 module="education"
                 model="article"
                 url="/education/articles"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('articles.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('articles.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('articles.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'product_type', field: 'product_type', label: t('articles.fields.product_type'), filterable: true, sortable: true },
  { name: 'invoicing_policy', field: 'invoicing_policy', label: t('articles.fields.invoicing_policy'), filterable: true, sortable: true },
  { name: 'sale_price', field: 'sale_price', label: t('articles.fields.sale_price'), filterable: true, sortable: true },
  { name: 'vat', field: 'vat', label: t('articles.fields.vat'), filterable: true, sortable: true },
  { name: 'default_code', field: 'default_code', label: t('articles.fields.default_code'), filterable: true, sortable: true },
  { name: 'barcode', field: 'barcode', label: t('articles.fields.barcode'), filterable: true, sortable: true },
  { name: 'category', field: 'category', label: t('articles.fields.category'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'categories' },
  { name: 'unit', field: 'unit', label: t('articles.fields.unit'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'measureUnits' },
  { name: 'currency', field: 'currency', label: t('articles.fields.currency'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'currencies' },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.articles.update', params: { id: row.id } };
}
</script>

<style scoped></style>