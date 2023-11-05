<template>
  <ResourceTable :columns="columns"
                 :title="$t('users.title')"
                 module="base"
                 model="user"
                 url="/users"
                 :edit-link="editLink">

    <template #body-cell-theme="{ value }">
      <span v-if="value === 'light'"
            class="badge bg-secondary"></span>

      <span v-else-if="value === 'dark'"
            class="badge bg-black"></span>

      <span v-else
            class="badge bg-secondary-lt"></span>

      {{ value.value ? $t(`users.theme.${value.value}`) : '' }}
    </template>

    <template #body-cell-status="{ value }">
      <span :class="{ 'bg-success-lt': value, 'bg-secondary-lt': !value }"
            class="badge py-1">
        {{ value === true ? $t('users.status.active') : $t('users.status.inactive') }}
      </span>
    </template>
  </ResourceTable>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import ResourceTable from '@/components/ResourceTable.vue';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('users.fields.id'), required: true, dataType: 'number', sortable: true, filterable: true },
  { name: 'first_name', field: 'first_name', label: t('users.fields.first_name'), filterable: true, sortable: true, required: true },
  { name: 'last_name', field: 'last_name', label: t('users.fields.last_name'), filterable: true, sortable: true, required: true },
  { name: 'email', field: 'email', label: t('users.fields.email'), filterable: true, sortable: true, required: true },
  { name: 'theme', field: 'theme', label: t('users.fields.theme'), filterable: true, sortable: true, dataType: 'enum', enum: { light: t('users.theme.light'), dark: t('users.theme.dark') } },
  { name: 'status', field: 'status', label: t('users.fields.status'), filterable: true, sortable: true, dataType: 'boolean' },
  { name: 'language', field: 'language', label: t('users.fields.language'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'languages', filterField: 'language.id' },
  { name: 'actions', field: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.users.update', params: { id: row.id } };
}
</script>