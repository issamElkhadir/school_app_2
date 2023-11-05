<template>
  <ResourceTable :title="t('categories.title')"
                 :columns="columns"
                 module="education"
                 model="translation"
                 url="/education/categories"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('categories.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('categories.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('categories.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'short_name', field: 'short_name', label: t('categories.fields.short_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('categories.fields.status'), filterable: true, sortable: true },
  { name: 'category', field: 'category', label: t('categories.fields.category'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'categories' },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.categories.update', params: { id: row.id } };
}
</script>

<style scoped></style>