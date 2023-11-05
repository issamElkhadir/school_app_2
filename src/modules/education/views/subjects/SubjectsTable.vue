<template>
  <ResourceTable :title="t('subjects.title')"
                 :columns="columns"
                 module="education"
                 model="subject"
                 url="/education/subjects"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('subjects.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'name', field: 'name', label: t('subjects.fields.name'), filterable: true, sortable: true },
  { name: 'color', field: 'color', label: t('subjects.fields.color'), filterable: true, sortable: true },
  { name: 'massar_id', field: 'massar_id', label: t('subjects.fields.massar_id'), filterable: true, sortable: true },
  { name: 'order', field: 'order', label: t('subjects.fields.order'), filterable: true, sortable: true },
  { name: 'picture', field: 'picture', label: t('subjects.fields.picture'), filterable: true, sortable: true },
  { name: 'unity', field: 'unity', label: t('subjects.fields.unity'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'unities' },
  { name: 'classroomType', field: 'classroomType', label: t('subjects.fields.classroomType'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'classroom-types' },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.subjects.update', params: { id: row.id } };
}
</script>

<style scoped></style>