<template>
  <ResourceTable :title="t('mail-servers.title')"
                 :columns="columns"
                 module="base"
                 model="mail-server"
                 url="/mail-servers"
                 :edit-link="editLink">
    <template #body-cell-actions="{ onDelete, row }">
      <ResourceActions @delete="onDelete"
                       :row="row"
                       :edit-link="{ name: 'admin.mail-servers.update', params: { id: row.id } }" />
    </template>
  </ResourceTable>
</template>

<script setup>
import ResourceActions from "@/components/ResourceActions.vue";
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('mail-servers.fields.id'), filterable: true, sortable: true, required: true, dataType: 'number', exportable: true },
  { name: 'name', field: 'name', label: t('mail-servers.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'priority', field: 'priority', label: t('mail-servers.fields.priority'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'active', field: 'active', label: t('mail-servers.fields.active'), filterable: true, sortable: true, dataType: 'boolean', exportable: true },
  { name: 'username', field: 'username', label: t('mail-servers.fields.username'), filterable: true, sortable: true, exportable: true },
  { name: 'smtp_host', field: 'smtp_host', label: t('mail-servers.fields.smtp_host'), filterable: true, sortable: true, exportable: true },
  { name: 'smtp_port', field: 'smtp_port', label: t('mail-servers.fields.smtp_port'), filterable: true, sortable: true, dataType: 'number', exportable: true },
  { name: 'smtp_encryption', field: 'smtp_encryption', label: t('mail-servers.fields.smtp_encryption'), filterable: true, sortable: true, dataType: 'enum', exportable: true },
  { name: 'actions', field: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.mail-servers.update', params: { id: row.id } };
}
</script>

<style scoped></style>