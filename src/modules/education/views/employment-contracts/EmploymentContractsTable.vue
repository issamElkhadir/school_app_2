<template>
    <ResourceTable :title="t('employment-contracts.title')"
                   :columns="columns"
                   module="education"
                   model="employment_contract"
                   url="/education/employment-contracts"
                   :edit-link="editLink" />
  </template>
  
  <script setup>
  import ResourceTable from "@/components/ResourceTable.vue";
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const columns = [
    { name: 'id', field: 'id', label: t('employment-contracts.fields.id'), filterable: true, sortable: true, required: true },
    { name: 'contract_start_date', field: 'contract_start_date', label: t('employment-contracts.fields.contract_start_date'), filterable: true, sortable: true , dataType:"date" },
    { name: 'contract_end_date', field: 'contract_end_date', label: t('employment-contracts.fields.contract_end_date'), filterable: true, sortable: true , dataType:"date" },
    { name: 'net_salary', field: 'net_salary', label: t('employment-contracts.fields.net_salary'), filterable: true, sortable: true , dataType:"number" },
    { name: 'brut_salary', field: 'brut_salary', label: t('employment-contracts.fields.brut_salary'), filterable: true, sortable: true , dataType:"number" },
    { name: 'nbr_days_off', field: 'nbr_days_off', label: t('employment-contracts.fields.nbr_days_off'), filterable: true, sortable: true , dataType:"number" },
  
    { name: 'staff', field: 'staff', label: t('employment-contracts.fields.staff'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/staff' },
    { name: 'contract_type', field: 'contract_type', label: t('employment-contracts.fields.contract_type'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'education/contract_types' },
    { name: 'actions', field: 'actions', required: true },
  ];
  
  const editLink = (row) => {
    return { name: 'admin.employment-contracts.update', params: { id: row.id } };
  }
  </script>
  
  <style scoped></style>