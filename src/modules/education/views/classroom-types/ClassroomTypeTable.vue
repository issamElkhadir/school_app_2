<template>
  <ResourceTable :title="t('classroom-types.title')"
                 :columns="columns"
                 module="education"
                 model="classroom-types"
                 url="/education/classroom-types"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('classroom-types.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('classroom-types.fields.name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('classroom-types.fields.status'), filterable: true, sortable: true },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.classroom-types.update', params: { id: row.id } };
}
</script>

<style scoped></style>