<template>
  <ResourceTable :title="t('subscriptions.title')"
                 :columns="columns"
                 module="education"
                 model="student"
                 url="/education/subscriptions"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('subscriptions.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'principal', field: 'principal', label: t('subscriptions.fields.principal'), filterable: true, sortable: true },
  { name: 'subscription_date', field: 'subscription_date', label: t('subscriptions.fields.subscription_date'), filterable: true, sortable: true },
  { name: 'sequence', field: 'sequence', label: t('subscriptions.fields.sequence'), filterable: true, sortable: true },

  { name: 'class', field: 'class', label: t('subscriptions.fields.class'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'classes' },
  { name: 'student', field: 'student', label: t('subscriptions.fields.student'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'students', nameAttribute: 'first_name' },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.subscriptions.update', params: { id: row.id } };
}
</script>

<style scoped></style>