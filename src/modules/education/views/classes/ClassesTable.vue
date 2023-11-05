<template>
  <ResourceTable :title="t('classes.title')"
                 :columns="columns"
                 module="education"
                 model="clazz"
                 url="/education/classes"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('classes.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('classes.fields.name'), filterable: true, sortable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('classes.fields.rtl_name'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('classes.fields.status'), filterable: true, sortable: true },
  { name: 'school', field: 'school', label: t('classes.fields.school'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'schools' },
  { name: 'parentClass', field: 'school', label: t('classes.fields.parentClass'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'classes' },
  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.classes.update', params: { id: row.id } };
}
</script>

<style scoped></style>