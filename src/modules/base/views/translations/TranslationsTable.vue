<template>
  <ResourceTable :title="t('translations.title')"
                 :columns="columns"
                 module="base"
                 model="translation"
                 url="/translations"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('translations.fields.id'), filterable: true, sortable: true, required: true, exportable: true },
  { name: 'module', field: 'module', label: t('translations.fields.module'), filterable: true, sortable: true, exportable: true },
  { name: 'model', field: 'model', label: t('translations.fields.model'), filterable: true, sortable: true, exportable: true },
  { name: 'key', field: 'key', label: t('translations.fields.key'), filterable: true, sortable: true, exportable: true },
  { name: 'value', field: 'value', label: t('translations.fields.value'), filterable: true, sortable: true, exportable: true },
  { name: 'language', field: 'language', label: t('translations.fields.language'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'languages', exportable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.translations.update', params: { id: row.id } };
}
</script>

<style scoped></style>