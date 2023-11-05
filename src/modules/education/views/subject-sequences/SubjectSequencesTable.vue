<template>
  <ResourceTable :title="t('subject-sequences.title')"
                 :columns="columns"
                 module="education"
                 model="subject-sequence"
                 url="/education/subject-sequences"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('subject-sequences.fields.id'), filterable: true, sortable: true, required: true },
  // {name: 'content', field: 'content', label: t('subject-sequences.fields.content'), filterable: true, sortable: true},
  { name: 'nbh', field: 'nbh', label: t('subject-sequences.fields.nbh'), filterable: true, sortable: true },
  { name: 'status', field: 'status', label: t('subject-sequences.fields.status'), filterable: true, sortable: true },
  { name: 'subject', field: 'subject', label: t('subject-sequences.fields.subject'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'subjects' },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.subject-sequences.update', params: { id: row.id } };
}
</script>

<style scoped></style>