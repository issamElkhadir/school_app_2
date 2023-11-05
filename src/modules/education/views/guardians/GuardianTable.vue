<template>
  <ResourceTable :title="t('guardians.title')"
                 :columns="columns"
                 module="education"
                 model="guardian"
                 url="/education/guardians"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('guardians.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'first_name', field: 'first_name', label: t('guardians.fields.first_name'), filterable: true, sortable: true },
  { name: 'last_name', field: 'last_name', label: t('guardians.fields.last_name'), filterable: true, sortable: true },
  { name: 'rtl_first_name', field: 'rtl_first_name', label: t('guardians.fields.rtl_first_name'), filterable: true, sortable: true },
  { name: 'rtl_last_name', field: 'rtl_last_name', label: t('guardians.fields.rtl_last_name'), filterable: true, sortable: true },
  { name: 'cni_number', field: 'cni_number', label: t('guardians.fields.cni_number'), filterable: true, sortable: true },
  { name: 'home_phone', field: 'home_phone', label: t('guardians.fields.home_phone'), filterable: true, sortable: true },
  { name: 'mobile_phone', field: 'mobile_phone', label: t('guardians.fields.mobile_phone'), filterable: true, sortable: true },
  { name: 'email_address', field: 'email_address', label: t('guardians.fields.email_address'), filterable: true, sortable: true },
  { name: 'country', field: 'country', label: t('guardians.fields.country'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'countries' },
  { name: 'city', field: 'city', label: t('guardians.fields.city'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'cities' },
  { name: 'gender', field: 'gender', label: t('guardians.fields.gender'), filterable: true, sortable: true },
  { name: 'actions', required: true },
];

const editLink = (row) => {
  return { name: 'admin.guardians.update', params: { id: row.id } };
}
</script>

<style scoped></style>