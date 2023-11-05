<template>
  <ResourceTable :title="t('levels.title')"
                 :columns="columns"
                 module="education"
                 model="level"
                 url="/education/levels"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('levels.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('levels.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('levels.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'short_name', field: 'short_name', label: t('levels.fields.short_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('levels.fields.status'), filterable: true, sortable: true },
  { name: 'description', field: 'description', label: t('levels.fields.description'), filterable: true, sortable: true },
  { name: 'branch', field: 'branch', label: t('levels.fields.branch'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'branches' },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.levels.update', params: { id: row.id } };
}
</script>

<style scoped></style>